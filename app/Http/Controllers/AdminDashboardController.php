<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with stats and optional unified search results.
     * All counts are retrieved using raw SQL queries (PL/SQL style).
     */
    public function index(Request $request)
    {
        // ── Raw SQL counts ──────────────────────────────────────────────────
        $totalDonors    = DB::selectOne('SELECT COUNT(*) AS cnt FROM donor')->cnt;
        $totalNGOs      = DB::selectOne('SELECT COUNT(*) AS cnt FROM ngo_volunteer')->cnt;
        $totalDonations = DB::selectOne('SELECT COUNT(*) AS cnt FROM donation')->cnt;
        $totalRequests  = DB::selectOne('SELECT COUNT(*) AS cnt FROM food_requests')->cnt;

        // ── Unified Search ──────────────────────────────────────────────────
        $q          = $request->input('q');
        $date       = $request->input('date');
        $searchResults = [];
        $hasSearch  = $request->has('q') || $request->has('date');

        if ($hasSearch) {
            try {
                // Try the PL/SQL stored procedure first
                $searchResults = DB::select('CALL search_dashboard(?, ?)', [$q, $date]);
            } catch (\Exception $e) {
                // Fallback: raw SQL UNION query when the stored procedure is unavailable
                $searchResults = DB::select("
                    SELECT id, 'donor' AS type,
                           CONCAT(first_name, ' ', last_name) AS name,
                           city, organisation AS detail,
                           NULL AS date_from, NULL AS date_to
                    FROM donor
                    WHERE (? IS NULL OR ? = ''
                        OR CONCAT(first_name, ' ', last_name) LIKE CONCAT('%', ?, '%')
                        OR city         LIKE CONCAT('%', ?, '%')
                        OR organisation LIKE CONCAT('%', ?, '%')
                        OR phone        LIKE CONCAT('%', ?, '%')
                        OR email        LIKE CONCAT('%', ?, '%'))
                      AND (? IS NULL OR ? = '')

                    UNION ALL

                    SELECT id, 'ngo' AS type,
                           CONCAT(first_name, ' ', last_name) AS name,
                           city, organisation AS detail,
                           NULL AS date_from, NULL AS date_to
                    FROM ngo_volunteer
                    WHERE (? IS NULL OR ? = ''
                        OR CONCAT(first_name, ' ', last_name) LIKE CONCAT('%', ?, '%')
                        OR city         LIKE CONCAT('%', ?, '%')
                        OR organisation LIKE CONCAT('%', ?, '%')
                        OR phone        LIKE CONCAT('%', ?, '%')
                        OR email        LIKE CONCAT('%', ?, '%'))
                      AND (? IS NULL OR ? = '')

                    UNION ALL

                    SELECT d.id, 'donation' AS type,
                           d.food_name AS name,
                           d.pickup_address AS city,
                           d.category AS detail,
                           d.pickup_from AS date_from, d.pickup_to AS date_to
                    FROM donation d
                    WHERE (? IS NULL OR ? = ''
                        OR d.food_name     LIKE CONCAT('%', ?, '%')
                        OR d.pickup_address LIKE CONCAT('%', ?, '%')
                        OR d.category      LIKE CONCAT('%', ?, '%')
                        OR d.donor_name    LIKE CONCAT('%', ?, '%'))
                      AND (? IS NULL OR ? = ''
                        OR (DATE(?) BETWEEN DATE(d.pickup_from) AND DATE(d.pickup_to)))

                    UNION ALL

                    SELECT fr.id, 'request' AS type,
                           IFNULL(d.food_name, 'Food Request') AS name,
                           fr.requester_city AS city,
                           fr.purpose AS detail,
                           fr.preferred_pickup_from AS date_from,
                           fr.preferred_pickup_to   AS date_to
                    FROM food_requests fr
                    LEFT JOIN donation d ON fr.donation_id = d.id
                    WHERE (? IS NULL OR ? = ''
                        OR fr.requester_name  LIKE CONCAT('%', ?, '%')
                        OR fr.requester_city  LIKE CONCAT('%', ?, '%')
                        OR fr.purpose         LIKE CONCAT('%', ?, '%')
                        OR fr.delivery_address LIKE CONCAT('%', ?, '%')
                        OR d.food_name         LIKE CONCAT('%', ?, '%'))
                      AND (? IS NULL OR ? = ''
                        OR (DATE(?) BETWEEN DATE(fr.preferred_pickup_from)
                                       AND DATE(fr.preferred_pickup_to)))
                ", [
                    // donor block  (7 params + 2 for date)
                    $q, $q, $q, $q, $q, $q, $q, $date, $date,
                    // ngo block    (7 params + 2 for date)
                    $q, $q, $q, $q, $q, $q, $q, $date, $date,
                    // donation block — keyword (6) + date (3)
                    $q, $q, $q, $q, $q, $q,
                    $date, $date, $date,
                    // request block — keyword (7) + date (3)
                    $q, $q, $q, $q, $q, $q, $q,
                    $date, $date, $date,
                ]);
            }
        }

        return view('dashboard', compact(
            'totalDonors', 'totalNGOs', 'totalDonations', 'totalRequests',
            'searchResults', 'hasSearch', 'q', 'date'
        ));
    }
}

<?php
/* Template Name: View Attendance */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Attendance Records</h1>

        <?php
        global $wpdb;

        // Get current month and year
        $current_month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
        $current_year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

        // Number of days in the selected month
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);

        // Fetch members
        $members = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users");

        // Fetch attendance records for the selected month
        $attendance_table = $wpdb->prefix . 'attendance';
        $attendance_results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $attendance_table WHERE MONTH(date) = %d AND YEAR(date) = %d",
                $current_month,
                $current_year
            )
        );

        // Fetch payment records for the selected month
        $payments_table = $wpdb->prefix . 'payments';
        $payment_results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $payments_table WHERE MONTH(payment_date) = %d AND YEAR(payment_date) = %d",
                $current_month,
                $current_year
            )
        );

        // Initialize arrays to store attendance and payment data
        $attendance_data = [];
        foreach ($attendance_results as $row) {
            $attendance_data[$row->member_id][$row->date] = true;
        }

        $payment_data = [];
        foreach ($payment_results as $payment) {
            $payment_data[$payment->member_id][$payment->payment_date][] = [
                'amount' => $payment->amount,
                'payment_type' => $payment->payment_type
            ];
        }

        // Handle filtering
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        $filtered_members = [];

        if ($filter == 'non_attendees') {
            foreach ($members as $member) {
                $has_attendance = false;
                foreach ($attendance_data as $member_id => $dates) {
                    if ($member->ID == $member_id) {
                        $has_attendance = true;
                        break;
                    }
                }
                if (!$has_attendance) {
                    $filtered_members[] = $member;
                }
            }
        } elseif ($filter == 'marked') {
            foreach ($members as $member) {
                $has_attendance = false;
                foreach ($attendance_data as $member_id => $dates) {
                    if ($member->ID == $member_id) {
                        $has_attendance = true;
                        break;
                    }
                }
                if ($has_attendance) {
                    $filtered_members[] = $member;
                }
            }
        } else {
            $filtered_members = $members;
        }
        ?>

        <!-- Month Navigation -->
        <div class="month-navigation">
            <a href="?month=<?php echo ($current_month == 1) ? 12 : $current_month - 1; ?>&year=<?php echo ($current_month == 1) ? $current_year - 1 : $current_year; ?>">Previous Month</a>
            <span><?php echo date('F Y', strtotime("$current_year-$current_month-01")); ?></span>
            <a href="?month=<?php echo ($current_month == 12) ? 1 : $current_month + 1; ?>&year=<?php echo ($current_month == 12) ? $current_year + 1 : $current_year; ?>">Next Month</a>
        </div>

        <!-- Filters -->
        <div class="filters">
            <a href="?filter=marked">Marked Members</a>
            <a href="?filter=non_attendees">Non-Attendees</a>
            <a href="?filter=reset">Reset Filter</a>
        </div>

        <!-- Scrollable Table Container -->
        <div style="overflow-x: auto;">
            <form method="post" action="">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <?php for ($day = 1; $day <= $days_in_month; $day++): ?>
                                <th><?php echo $day; ?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filtered_members as $member): ?>
                            <tr>
                                <td><?php echo esc_html($member->ID); ?></td>
                                <td><?php echo esc_html($member->display_name); ?></td>
                                <?php for ($day = 1; $day <= $days_in_month; $day++): 
                                    $date = sprintf('%04d-%02d-%02d', $current_year, $current_month, $day);
                                    $marked = isset($attendance_data[$member->ID][$date]) ? 'X' : '';
                                    $payment = isset($payment_data[$member->ID][$date]) ? $payment_data[$member->ID][$date] : [];
                                ?>
                                    <td>
                                        <?php echo esc_html($marked); ?>
                                        <?php foreach ($payment as $pmt): ?>
                                            <div class="payment"><?php echo esc_html($pmt['amount'] . ' (' . $pmt['payment_type'] . ')'); ?></div>
                                        <?php endforeach; ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

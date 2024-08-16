<?php
/* Template Name: View Attendance */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Attendance Records</h1>

        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'attendance';
        $results = $wpdb->get_results("SELECT * FROM $table_name");

        if ($results): ?>
            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo get_the_author_meta('display_name', $row->member_id); ?></td>
                            <td><?php echo esc_html($row->date); ?></td>
                            <td><?php echo esc_html($row->time_in); ?></td>
                            <td><?php echo esc_html($row->time_out); ?></td>
                            <td><?php echo esc_html($row->notes); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No attendance records found.</p>
        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

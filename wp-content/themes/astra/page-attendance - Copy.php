<?php
/* Template Name: Attendance Page */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Mark Attendance</h1>

        <form method="post" action="">
            <?php
            // Fetch all users
            $users = get_users();

            // Create the dropdown menu
            ?>
            <label for="member">Select Member:</label>
            <select name="member" id="member" required>
                <option value="">Select a member</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo esc_attr($user->ID); ?>">
                        <?php echo esc_html($user->display_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>

            <label for="time_in">Time In:</label>
            <input type="time" name="time_in" id="time_in" required>

            <label for="time_out">Time Out:</label>
            <input type="time" name="time_out" id="time_out">

            <label for="notes">Notes:</label>
            <textarea name="notes" id="notes"></textarea>

            <input type="submit" name="submit_attendance" value="Submit">
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit_attendance'])) {
            $member_id = intval($_POST['member']);
            $date = sanitize_text_field($_POST['date']);
            $time_in = sanitize_text_field($_POST['time_in']);
            $time_out = sanitize_text_field($_POST['time_out']);
            $notes = sanitize_textarea_field($_POST['notes']);

            // Save the data to the database
            global $wpdb;
            $table_name = $wpdb->prefix . 'attendance';

            // Create the table if it doesn’t exist
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id BIGINT(20) NOT NULL AUTO_INCREMENT,
                member_id BIGINT(20) NOT NULL,
                date DATE NOT NULL,
                time_in TIME NOT NULL,
                time_out TIME,
                notes TEXT,
                PRIMARY KEY (id)
            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            // Insert the data
            $wpdb->insert($table_name, array(
                'member_id' => $member_id,
                'date' => $date,
                'time_in' => $time_in,
                'time_out' => $time_out,
                'notes' => $notes,
            ));

            echo '<p>Attendance marked successfully!</p>';
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

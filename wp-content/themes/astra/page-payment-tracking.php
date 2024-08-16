<?php
/* Template Name: Payment Tracking Page */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Track Payment</h1>

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
            <input type="date" name="date" id="date" value="<?php echo date('Y-m-d'); ?>" required>

            <label for="amount">Amount:</label>
            <input type="number" name="amount" id="amount" step="0.01" required>

            <label>Type:</label>
            <label><input type="radio" name="payment_type" value="new_reg" required> New Registration</label>
            <label><input type="radio" name="payment_type" value="monthly_fee"> Monthly Fee</label>
            <label><input type="radio" name="payment_type" value="day_fee"> Day Fee</label>

            <input type="submit" name="submit_payment" value="Submit">
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit_payment'])) {
            $member_id = intval($_POST['member']);
            $date = sanitize_text_field($_POST['date']);
            $amount = floatval($_POST['amount']);
            $payment_type = sanitize_text_field($_POST['payment_type']);

            // Save the data to the database
            global $wpdb;
            $table_name = $wpdb->prefix . 'payments';

            // Create the table if it doesn’t exist
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id BIGINT(20) NOT NULL AUTO_INCREMENT,
                member_id BIGINT(20) NOT NULL,
                date DATE NOT NULL,
                amount DECIMAL(10, 2) NOT NULL,
                payment_type VARCHAR(50) NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            // Insert the data
            $wpdb->insert($table_name, array(
                'member_id' => $member_id,
                'date' => $date,
                'amount' => $amount,
                'payment_type' => $payment_type,
            ));

            echo '<p>Payment recorded successfully!</p>';
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

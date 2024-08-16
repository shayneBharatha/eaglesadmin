<?php
/* Template Name: User Profile Page */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>User Profile</h1>

        <form method="post" action="">
            <label for="select_user">Select User:</label>
            <select name="select_user" id="select_user" required>
                <option value="">Select a user</option>
                <?php
                // Fetch all users
                $users = get_users();
                foreach ($users as $user) {
                    echo '<option value="' . esc_attr($user->ID) . '">' . esc_html($user->display_name) . '</option>';
                }
                ?>
            </select>

            <input type="submit" name="fetch_user" value="Fetch User Data">
        </form>

        <?php
        if (isset($_POST['fetch_user'])) {
            $user_id = intval($_POST['select_user']);

            // Fetch user info
            $user_info = get_userdata($user_id);
            if ($user_info) {
                // Fetch additional info
                global $wpdb;
                $table_name = $wpdb->prefix . 'additional_user_info';
                $additional_info = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id));

                if ($additional_info) {
                    ?>
                    <h2>Profile Details</h2>
                    <form method="post" action="">
                        <input type="hidden" name="user_id" value="<?php echo esc_attr($user_id); ?>">

                        <p><strong>Member ID:</strong> <?php echo esc_html($user_info->user_login); ?></p>
                        <p><strong>Email:</strong> <?php echo esc_html($user_info->user_email); ?></p>
                        <p><strong>First Name:</strong> <?php echo esc_html($additional_info->first_name); ?></p>
                        <p><strong>Other Names:</strong> <?php echo esc_html($additional_info->other_names); ?></p>
                        <p><strong>Last Name:</strong> <?php echo esc_html($additional_info->last_name); ?></p>
                        <p><strong>Address:</strong> <?php echo esc_html($additional_info->address); ?></p>
                        <p><strong>Contact Number:</strong> <?php echo esc_html($additional_info->contact_number); ?></p>
                        <p><strong>Occupation:</strong> <?php echo esc_html($additional_info->occupation); ?></p>
                        <p><strong>Institute:</strong> <?php echo esc_html($additional_info->institute); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo esc_html($additional_info->date_of_birth); ?></p>
                        <p><strong>NIC:</strong> <?php echo esc_html($additional_info->nic); ?></p>
                        <p><strong>Height:</strong> <?php echo esc_html($additional_info->height); ?></p>
                        <p><strong>Weight:</strong> <?php echo esc_html($additional_info->weight); ?></p>
                        <p><strong>BMI:</strong> <?php echo esc_html($additional_info->bmi); ?></p>
                        <p><strong>Registered Date:</strong> <?php echo esc_html($additional_info->registered_date); ?></p>
                        <p><strong>Emergency Contact Number:</strong> <?php echo esc_html($additional_info->emergency_contact_number); ?></p>
                        <p><strong>Emergency Contact Name:</strong> <?php echo esc_html($additional_info->emergency_contact_name); ?></p>
                        <p><strong>Emergency Contact Relationship:</strong> <?php echo esc_html($additional_info->emergency_contact_relationship); ?></p>
                        <p><strong>Guidance:</strong> <?php echo esc_html($additional_info->guidance); ?></p>
                        <p><strong>How Heard:</strong> <?php echo esc_html($additional_info->how_heard); ?></p>
                        <p><strong>Other Info:</strong> <?php echo esc_html($additional_info->other_info); ?></p>

                        <!-- Optionally, you can add a form to update user data here -->

                        <input type="submit" name="update_user" value="Update User Data">
                    </form>
                    <?php
                } else {
                    echo '<p>No additional info found for this user.</p>';
                }
            } else {
                echo '<p>User not found.</p>';
            }
        }

        // Handle user data update
        if (isset($_POST['update_user'])) {
            $user_id = intval($_POST['user_id']);

            // Update user info
            // Example of updating a user meta field
            // Add more fields to update as necessary
            update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            update_user_meta($user_id, 'other_names', sanitize_text_field($_POST['other_names']));
            // ... Add other fields to update

            echo '<p>User data updated successfully!</p>';
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

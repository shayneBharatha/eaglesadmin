<?php
/* Template Name: User Registration Page */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>User Registration</h1>

        <form method="post" action="">
            <label for="member_id">Member ID:</label>
            <input type="text" name="member_id" id="member_id" required>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="other_names">Other Names:</label>
            <input type="text" name="other_names" id="other_names">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address"></textarea>

            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number">

            <label for="occupation">Occupation:</label>
            <input type="text" name="occupation" id="occupation">

            <label for="institute">Institute:</label>
            <input type="text" name="institute" id="institute">

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" id="date_of_birth">

            <label for="nic">NIC:</label>
            <input type="text" name="nic" id="nic">

            <label for="height">Height (cm):</label>
            <input type="number" name="height" id="height" step="0.1">

            <label for="weight">Weight (kg):</label>
            <input type="number" name="weight" id="weight" step="0.1">

            <label for="bmi">BMI:</label>
            <input type="number" name="bmi" id="bmi" step="0.1" readonly>

            <label for="registered_date">Registered Date:</label>
            <input type="date" name="registered_date" id="registered_date">

            <label for="emergency_contact_number">Emergency Contact Number:</label>
            <input type="text" name="emergency_contact_number" id="emergency_contact_number">

            <label for="emergency_contact_name">Emergency Contact Name:</label>
            <input type="text" name="emergency_contact_name" id="emergency_contact_name">

            <label for="emergency_contact_relationship">Emergency Contact Relationship:</label>
            <input type="text" name="emergency_contact_relationship" id="emergency_contact_relationship">

            <label>Guidance:</label>
            <label><input type="radio" name="guidance" value="required" required> Required</label>
            <label><input type="radio" name="guidance" value="no_need"> No Need</label>
            <label><input type="radio" name="guidance" value="need_a_little"> Need a Little</label>

            <label>How did you hear about us?</label>
            <label><input type="radio" name="how_heard" value="posters" required> Posters</label>
            <label><input type="radio" name="how_heard" value="banners"> Banners</label>
            <label><input type="radio" name="how_heard" value="leaflets"> Leaflets</label>
            <label><input type="radio" name="how_heard" value="facebook"> Facebook</label>
            <label><input type="radio" name="how_heard" value="instagram"> Instagram</label>
            <label><input type="radio" name="how_heard" value="by_a_friend"> By a Friend</label>
            <label><input type="radio" name="how_heard" value="other"> Other</label>
            <input type="text" name="other_info" id="other_info" placeholder="If 'Other', please specify">

            <input type="submit" name="submit_registration" value="Register">
        </form>

        <?php
        // Handle form submission
        if (isset($_POST['submit_registration'])) {
            $member_id = sanitize_text_field($_POST['member_id']);
            $first_name = sanitize_text_field($_POST['first_name']);
            $other_names = sanitize_text_field($_POST['other_names']);
            $last_name = sanitize_text_field($_POST['last_name']);
            $email = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);
            $address = sanitize_textarea_field($_POST['address']);
            $contact_number = sanitize_text_field($_POST['contact_number']);
            $occupation = sanitize_text_field($_POST['occupation']);
            $institute = sanitize_text_field($_POST['institute']);
            $date_of_birth = sanitize_text_field($_POST['date_of_birth']);
            $nic = sanitize_text_field($_POST['nic']);
            $height = floatval($_POST['height']);
            $weight = floatval($_POST['weight']);
            $bmi = ($weight / (($height / 100) ** 2)); // Calculate BMI
            $registered_date = sanitize_text_field($_POST['registered_date']);
            $emergency_contact_number = sanitize_text_field($_POST['emergency_contact_number']);
            $emergency_contact_name = sanitize_text_field($_POST['emergency_contact_name']);
            $emergency_contact_relationship = sanitize_text_field($_POST['emergency_contact_relationship']);
            $guidance = sanitize_text_field($_POST['guidance']);
            $how_heard = sanitize_text_field($_POST['how_heard']);
            $other_info = sanitize_text_field($_POST['other_info']);

            // Create user
            $user_id = wp_create_user($member_id, $password, $email);
            if (is_wp_error($user_id)) {
                echo '<p>Error: ' . $user_id->get_error_message() . '</p>';
            } else {
                // Update user meta
                wp_update_user(array(
                    'ID' => $user_id,
                    'display_name' => $first_name,
                    'user_nicename' => $first_name,
                    'user_login' => $member_id,
                ));

                // Insert additional user info
                global $wpdb;
                $table_name = $wpdb->prefix . 'additional_user_info';
                $wpdb->insert($table_name, array(
                    'user_id' => $user_id,
                    'first_name' => $first_name,
                    'other_names' => $other_names,
                    'last_name' => $last_name,
                    'address' => $address,
                    'contact_number' => $contact_number,
                    'occupation' => $occupation,
                    'institute' => $institute,
                    'date_of_birth' => $date_of_birth,
                    'nic' => $nic,
                    'height' => $height,
                    'weight' => $weight,
                    'bmi' => $bmi,
                    'registered_date' => $registered_date,
                    'emergency_contact_number' => $emergency_contact_number,
                    'emergency_contact_name' => $emergency_contact_name,
                    'emergency_contact_relationship' => $emergency_contact_relationship,
                    'guidance' => $guidance,
                    'how_heard' => $how_heard,
                    'other_info' => $other_info,
                ));

                echo '<p>Registration successful!</p>';
            }
        }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>

<?php
/* Template Name: Payment Listing Page */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Payment Records</h1>

        <form method="get" action="">
            <label for="filter_member">Filter by Member:</label>
            <select name="filter_member" id="filter_member">
                <option value="">Select a member</option>
                <?php
                $users = get_users();
                foreach ($users as $user):
                    ?>
                    <option value="<?php echo esc_attr($user->ID); ?>" <?php selected(get_query_var('filter_member'), $user->ID); ?>>
                        <?php echo esc_html($user->display_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="filter_type">Filter by Type:</label>
            <select name="filter_type" id="filter_type">
                <option value="">Select payment type</option>
                <option value="new_reg" <?php selected(get_query_var('filter_type'), 'new_reg'); ?>>New Registration</option>
                <option value="monthly_fee" <?php selected(get_query_var('filter_type'), 'monthly_fee'); ?>>Monthly Fee</option>
                <option value="day_fee" <?php selected(get_query_var('filter_type'), 'day_fee'); ?>>Day Fee</option>
            </select>

            <label for="filter_date_from">Date From:</label>
            <input type="date" name="filter_date_from" id="filter_date_from" value="<?php echo get_query_var('filter_date_from'); ?>">

            <label for="filter_date_to">Date To:</label>
            <input type="date" name="filter_date_to" id="filter_date_to" value="<?php echo get_query_var('filter_date_to'); ?>">

            <input type="submit" value="Filter">
            <input type="reset" value="Reset" class="button">
        </form>

        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'payments';

        $where = '1=1';
        $params = array();

        if (!empty($_GET['filter_member'])) {
            $where .= ' AND member_id = %d';
            $params[] = intval($_GET['filter_member']);
        }

        if (!empty($_GET['filter_type'])) {
            $where .= ' AND payment_type = %s';
            $params[] = sanitize_text_field($_GET['filter_type']);
        }

        if (!empty($_GET['filter_date_from'])) {
            $where .= ' AND date >= %s';
            $params[] = sanitize_text_field($_GET['filter_date_from']);
        }

        if (!empty($_GET['filter_date_to'])) {
            $where .= ' AND date <= %s';
            $params[] = sanitize_text_field($_GET['filter_date_to']);
        }

        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE $where", $params);
        $results = $wpdb->get_results($query);

        if ($results): ?>
            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo get_the_author_meta('display_name', $row->member_id); ?></td>
                            <td><?php echo esc_html($row->date); ?></td>
                            <td><?php echo esc_html(number_format($row->amount, 2)); ?></td>
                            <td><?php echo esc_html(ucwords(str_replace('_', ' ', $row->payment_type))); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No payment records found.</p>
        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resetButton = document.querySelector('input[type="reset"]');

    if (resetButton) {
        resetButton.addEventListener('click', function() {
            // Clear filter parameters in the URL
            const url = new URL(window.location.href);
            url.searchParams.delete('filter_member');
            url.searchParams.delete('filter_type');
            url.searchParams.delete('filter_date_from');
            url.searchParams.delete('filter_date_to');
            window.location.href = url.toString();
        });
    }
});
</script>

<?php get_footer(); ?>

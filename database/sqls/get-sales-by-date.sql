SELECT
    DATE(orders.created_at) as day,
    COUNT(*) as total_orders,
    SUM(orders.discount + orders.policy_discount) as total_discount,
    SUM(line_items.quantity) as total_item_count,
    SUM(line_items.subtotal) as total_net_amount,
    SUM(line_items.subtotal + 0 + orders.shipping_cost - orders.discount - orders.policy_discount) as total_gross_amount
FROM
    orders
JOIN
    line_items ON line_items.order_id = orders.id
WHERE
    orders.created_at BETWEEN :start_date AND :end_date
GROUP BY
    day;

DATE(orders.created_at) as                                                                   day,
       COUNT(*) as                                                                      			total_orders,
       SUM(orders.discount+orders.policy_discount) as                                                                      total_discount,
       SUM((SELECT SUM(quantity)
            FROM `line_items`
            WHERE line_items.order_id = orders.id)) as                                              total_item_count,
       SUM((SELECT SUM(subtotal)
            FROM `line_items`
            WHERE line_items.order_id = orders.id)) as                                              total_net_amount,
       SUM((SELECT SUM(subtotal + 0) FROM `line_items` WHERE line_items.order_id = orders.id) +
           orders.shipping_cost - orders.discount - orders.policy_discount) as                                             total_gross_amount

SELECT
    pp.id AS package_id,
    SUM(last_prices.price * ppc.quantity) AS total_price
FROM
    product_packages pp
JOIN
    product_package_contents ppc ON pp.id = ppc.product_package_id
JOIN
    products p ON p.id = ppc.product_id
JOIN
    (
        SELECT
            product_id,
            price
        FROM
            price_history ph1
        WHERE
            ph1.updated_at = (
                SELECT MAX(updated_at)
                FROM price_history ph2
                WHERE ph2.product_id = ph1.product_id
                AND ph2.updated_at <= /*Set date in the following format: "2024-10-25"*/
            )
    ) AS last_prices ON p.id = last_prices.product_id
WHERE
    pp.id = /*Set the ID of the product_package*/
GROUP BY
    pp.id;

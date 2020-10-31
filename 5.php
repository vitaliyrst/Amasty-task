<?php

function getData($sql, $data = [])
{
    $config = [
        'host' => 'localhost',
        'dbname' => 'testbase',
        'user' => 'root',
        'password' => 'root',
    ];
    try {
        $dbh = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
            $config['user'], $config['password']);
    } catch (PDOException $e) {
        echo 'Что-то пошло не так, code: ' . $e->getCode();
        die();
    }
    $sth = $dbh->prepare($sql);
    $sth->execute($data);
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function getNameWithBalance()
{
    $sql = 'SELECT id, fullname, inter.amount + CASE WHEN SUM(tr.amount) IS NULL THEN 0 ELSE SUM(tr.amount) END as balance
FROM (SELECT id,
             fullname,
             CASE
                 WHEN 100 - SUM(t.amount) IS NULL THEN 100
                 ELSE 100 - SUM(t.amount) END AS amount
      FROM persons AS p
               LEFT JOIN transactions as t
                         ON p.id = t.from_person_id
      GROUP BY id, fullname) AS inter
         LEFT JOIN transactions as tr
                   ON inter.id = tr.to_person_id
GROUP BY id, fullname';
    return getData($sql);
}

function getCityMaxTransaction()
{
    $sql = '
SELECT c.name, COUNT(c.name) as sum_transactions
FROM transactions as t
         JOIN persons as p
              ON p.id = t.from_person_id
         JOIN cities c
              ON p.city_id = c.id
GROUP BY c.name
ORDER BY COUNT(c.name) DESC LIMIT 1
';
    return getData($sql);
}

function getTransactionBetweenSameCities()
{
    $sql = '
SELECT t.transaction_id, c.name as city FROM transactions as t
JOIN persons as p
ON p.id = t.from_person_id
JOIN cities as c
ON p.city_id = c.id
JOIN persons as pp
ON pp.id = t.to_person_id
JOIN cities as cc
ON pp.city_id = cc.id
WHERE c.name = cc.name
';
    return getData($sql);
}

$getNameAndBalance = getNameWithBalance();
var_dump($getNameAndBalance);

$getTopCity = getCityMaxTransaction();
var_dump($getTopCity);

$getTransaction = getTransactionBetweenSameCities();
var_dump($getTransaction);

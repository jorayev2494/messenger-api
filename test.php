<?php


/**
 *  CREATE TABLE wallets (
 *    user_id INT PRIMARY KEY,
 *    balance DECIMAL(10, 2) NOT NULL
 *  );
 */
function transferFunds(PDO $pdo, int $fromUserId, int $toUserId, int $amount)
{

    $fromUser = $pdo->prepare('SELECT balance FROM wallets WHERE user_id = ?')->execute([$fromUserId])->fetch();
    $toUser = $pdo->prepare('SELECT balance FROM wallets WHERE user_id = ?')->execute([$toUserId])->fetch();

    if ($fromUser === false || $toUser === false) {
        throw new Exception('User not found.');
    }

    if ($fromUser['balance'] < $amount) {
        throw new Exception("Insufficient funds.");
    }

    $fromUser['balance'] -= $amount;
    $toUser['balance'] += $amount;

    $pdo->prepare("UPDATE wallets SET balance = ? WHERE user_id = ?")->execute([$fromUser["balance"], $fromUserId]);
    $pdo->prepare("UPDATE wallets SET balance = ? WHERE user_id = ?")->execute([$toUser["balance"], $toUserId]);


    echo "Transfer successful!";

}



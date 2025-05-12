<?php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan ID aman dari SQL Injection

    $sql = "UPDATE notifikasi SET status = 'selesai' WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>window.location.href='?page=notifikasi&aksi=detail&id=$id';</script>";
    } else {
        echo "<script>window.history.back();</script>";
    }
} else {
    echo "<script>window.history.back();</script>";
}

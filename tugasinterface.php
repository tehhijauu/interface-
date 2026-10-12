<?php

interface MetodePembayaran
{
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

function formatRupiah(float $jumlah): string
{
    return 'Rp ' . number_format($jumlah, 0, ',', '.');
}

class TransferBank implements MetodePembayaran
{
    private string $nomorRekening;

    public function __construct(string $nomorRekening)
    {
        $this->nomorRekening = $nomorRekening;
    }

    public function getNamaMetode(): string
    {
        return 'Transfer Bank';
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $admin = 0;
        $total = $jumlah + $admin;

        echo "<h3>Transfer Bank</h3>";
        echo "Nomor Rekening: {$this->nomorRekening}<br>";
        echo "Keterangan: {$keterangan}<br>";
        echo "Jumlah Bayar: " . formatRupiah($jumlah) . "<br>";
        echo "Biaya Admin: " . formatRupiah($admin) . "<br>";
        echo "Total Pembayaran: " . formatRupiah($total) . "<br><br>";

        return true;
    }
}

class QRIS implements MetodePembayaran
{
    public function getNamaMetode(): string
    {
        return 'QRIS';
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $admin = $jumlah * 0.007;
        $total = $jumlah + $admin;

        echo "<h3>QRIS</h3>";
        echo "Keterangan: {$keterangan}<br>";
        echo "Jumlah Bayar: " . formatRupiah($jumlah) . "<br>";
        echo "Biaya Admin (0,7%): " . formatRupiah($admin) . "<br>";
        echo "Total Pembayaran: " . formatRupiah($total) . "<br><br>";

        return true;
    }
}

class KartuKredit implements MetodePembayaran
{
    private string $nomorKartu;

    public function __construct(string $nomorKartu)
    {
        $this->nomorKartu = $nomorKartu;
    }

    public function getNamaMetode(): string
    {
        return 'Kartu Kredit';
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool
    {
        $admin = $jumlah * 0.025;
        $total = $jumlah + $admin;
        $empatDigit = substr($this->nomorKartu, -4);

        echo "<h3>Kartu Kredit</h3>";
        echo "Nomor Kartu: **** **** **** {$empatDigit}<br>";
        echo "Keterangan: {$keterangan}<br>";
        echo "Jumlah Bayar: " . formatRupiah($jumlah) . "<br>";
        echo "Biaya Admin (2,5%): " . formatRupiah($admin) . "<br>";
        echo "Total Pembayaran: " . formatRupiah($total) . "<br><br>";

        return true;
    }
}

// Penggunaan objek
$transfer = new TransferBank('1234567890');
$qris = new QRIS();
$kartu = new KartuKredit('1234567812345678');

$transfer->prosesBayar(500000, 'Pembelian barang');
$qris->prosesBayar(500000, 'Pembelian barang');
$kartu->prosesBayar(500000, 'Pembelian barang');

?>
<?php

return [
    // Wajib
    'ktp_suami_istri' => [
        'label' => 'KTP Suami-Istri',
        'description' => 'Salinan KTP kedua belah pihak. Jika belum menikah, lampirkan KTP pemohon.',
        'required' => true,
    ],
    'npwp' => [
        'label' => 'NPWP',
        'description' => 'Nomor Pokok Wajib Pajak pemohon.',
        'required' => true,
    ],
    'kk' => [
        'label' => 'Kartu Keluarga (KK)',
        'description' => 'Salinan KK terbaru.',
        'required' => true,
    ],
    'bpjs' => [
        'label' => 'Kartu BPJS',
        'description' => 'Kartu BPJS aktif milik pemohon atau keluarga.',
        'required' => true,
    ],
    'slip_gaji_3_bulan' => [
        'label' => 'Slip Gaji 3 Bulan Terakhir',
        'description' => 'Lampirkan slip gaji untuk 3 bulan terakhir.',
        'required' => true,
    ],

    // Opsional
    'buku_nikah' => [
        'label' => 'Buku Nikah',
        'description' => 'Lampirkan jika sudah menikah.',
        'required' => false,
    ],
    'surat_keterangan_kerja' => [
        'label' => 'Surat Keterangan Kerja',
        'description' => 'Diterbitkan oleh perusahaan tempat bekerja.',
        'required' => false,
    ],
    'rekening_koran_4_bulan' => [
        'label' => 'Rekening Koran 4 Bulan Terakhir',
        'description' => 'Mutasi rekening selama 4 bulan terakhir.',
        'required' => false,
    ],
    'rekening_koran_6_bulan' => [
        'label' => 'Rekening Koran 6 Bulan Terakhir',
        'description' => 'Mutasi rekening selama 6 bulan terakhir.',
        'required' => false,
    ],
    'laporan_keuangan_6_bulan' => [
        'label' => 'Laporan Keuangan 6 Bulan Terakhir',
        'description' => 'Untuk wirausaha/pekerja lepas.',
        'required' => false,
    ],
    'izin_usaha' => [
        'label' => 'Izin Usaha (SIUP/SITU/TDP)',
        'description' => 'Dokumen legalitas usaha bagi wirausaha.',
        'required' => false,
    ],
    'foto_usaha_6_lembar' => [
        'label' => 'Foto Usaha 6 Lembar (Survey Bank)',
        'description' => 'Dokumentasi usaha untuk keperluan survey bank.',
        'required' => false,
    ],
    'surat_belum_memiliki_rumah' => [
        'label' => 'Surat Belum Memiliki Rumah dari Lurah',
        'description' => 'Surat keterangan belum memiliki rumah.',
        'required' => false,
    ],
    'surat_keterangan_belum_menikah' => [
        'label' => 'Surat Keterangan Belum Menikah dari Lurah',
        'description' => 'Untuk pemohon yang belum menikah.',
        'required' => false,
    ],
    'surat_keterangan_domisili' => [
        'label' => 'Surat Keterangan Domisili dari Lurah',
        'description' => 'Surat keterangan domisili sesuai alamat saat ini.',
        'required' => false,
    ],
    'bukti_pelunasan_uang_muka' => [
        'label' => 'Bukti Pelunasan Uang Muka',
        'description' => 'Bukti transfer/kwitansi pelunasan DP.',
        'required' => false,
    ],
];

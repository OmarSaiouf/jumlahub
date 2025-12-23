<?php

return [
    'create_order' => [
        'close' => 'Kaydı kapat',
        'default_category' => 'Ürün',
        'description_fallback' => 'Siparişinizi hazırlayın ve özel notlar ekleyin; satış ekibimiz yakında detayları inceleyecektir.',
        'unit' => 'adet',
        'available' => 'Şimdi mevcut',
        'sold' => 'Satıldı',
        'ready_to_ship' => 'Paketleme ve sevkiyata hazır',
        'eyebrow' => 'Sipariş detayları',
        'headline' => 'Sipariş işlemini başlatmak için bilgilerinizi girin',
        'muted' => 'Siparişi inceleyeceğiz ve en iyi ödeme yöntemini seçerek sizinle onaylayacağız.',
        'quantity_label' => 'Talep edilen miktar',
        'help_text' => 'Sipariş toplamı otomatik olarak güncellenecektir.',
        'payment_label' => 'Tercih edilen ödeme yöntemi',
        'choose_payment' => 'Bir ödeme yöntemi seçin',
        'notes_placeholder' => 'Teslim alma/gönderim detayları veya özel gereksinimler',
        'notes_label' => 'Notlar',
        'out_of_stock' => 'İstenilen miktar şu anda yok — stok yenilendiğinde bilgilendirileceksiniz.',
        'estimate_total' => 'Tahmini toplam',
        'prices_include' => 'Fiyatlara teslimata kadar destek dahildir',
        'cancel' => 'İptal',
        'confirm' => 'Siparişi onayla',
    ],

    'product' => [
        'sold' => 'satıldı',
        'remaining' => 'kalan',
        'min_order' => 'Minimum sipariş: 1 adet',
        'delivery_time' => '5-7 gün içinde teslim',
        'create_order' => 'Toptan sipariş oluştur',
        'details' => 'Daha fazla detay',
        'default' => 'Ürün',
    ],

    'order' => [
        'status' => [
            'pending' => 'Yolda',
            'processing' => 'Ödeme bekleniyor',
            'completed' => 'Teslim edildi',
            'cancelled' => 'İptal edildi',
            'refunded' => 'İade edildi',
        ],
        'copy' => [
            'quantity' => 'Miktar:',
            'amount' => 'Sipariş tutarı:',
            'date' => 'Sipariş tarihi:',
            'pendingTitle' => 'Siparişiniz yolda',
            'pendingText' => 'Gönderimi şimdi hazırlıyoruz ve ayrıldığında sizi bilgilendireceğiz.',
            'processingText' => 'Ödeme tamamlanmadı. Lütfen siparişin gönderimi için ödemeyi tamamlayın.',
            'defaultTitle' => 'Güncel sipariş durumu',
            'cta' => 'Ödemeye devam et',
            'details' => 'Sipariş detayları',
            "cancel" => "Siparişi iptal et"
        ],
    ],

    'share' => [
        'copy_title' => 'Bağlantıyı kopyala',
        'copied_alert' => 'Ürün bağlantısı kopyalandı ✅',
    ],

    'toast' => [
        'success' => 'Başarılı',
        'error' => 'Hata',
        'input_errors' => 'Girdi hataları',
    ],

    'category_details' => [
        'title' => 'JumlaHub | :name',
        'selected_offers' => 'Seçilen teklifler',
        'products_ready' => 'Toptan sipariş için hazır ürünler',
        'muted' => 'Mağazanıza kolay gönderim için kalite taramasından geçirilmiş seçimler.',
        'manage_orders' => 'Siparişlerimi Yönet',
        'no_products' => 'Şu anda ürün yok',
        'coming_soon' => 'Bu kategori için ürünler yakında eklenecek',
        'products_count' => ':count ürün',
    ],
];

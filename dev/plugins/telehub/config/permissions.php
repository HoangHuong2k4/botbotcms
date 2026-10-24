<?php

return [
    [
        'name' => 'Telehub',
        'flag' => 'telehub.index',
    ],
    // Tenants
    [
        'name' => 'Tenants',
        'flag' => 'telehub.tenants.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.tenants.create',
        'parent_flag' => 'telehub.tenants.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.tenants.edit',
        'parent_flag' => 'telehub.tenants.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.tenants.destroy',
        'parent_flag' => 'telehub.tenants.index',
    ],
    // Bot Configs
    [
        'name' => 'Bot Configs',
        'flag' => 'telehub.bot-configs.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.bot-configs.create',
        'parent_flag' => 'telehub.bot-configs.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.bot-configs.edit',
        'parent_flag' => 'telehub.bot-configs.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.bot-configs.destroy',
        'parent_flag' => 'telehub.bot-configs.index',
    ],
    // Products
    [
        'name' => 'Products',
        'flag' => 'telehub.products.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.products.create',
        'parent_flag' => 'telehub.products.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.products.edit',
        'parent_flag' => 'telehub.products.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.products.destroy',
        'parent_flag' => 'telehub.products.index',
    ],
    // Product Items
    [
        'name' => 'Product Combos',
        'flag' => 'telehub.product-combos.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.product-combos.create',
        'parent_flag' => 'telehub.product-combos.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.product-combos.edit',
        'parent_flag' => 'telehub.product-combos.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.product-combos.destroy',
        'parent_flag' => 'telehub.product-combos.index',
    ],
    // Product Items
    [
        'name' => 'Product Items',
        'flag' => 'telehub.product-items.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.product-items.create',
        'parent_flag' => 'telehub.product-items.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.product-items.edit',
        'parent_flag' => 'telehub.product-items.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.product-items.destroy',
        'parent_flag' => 'telehub.product-items.index',
    ],
    // Customers
    [
        'name' => 'Customers',
        'flag' => 'telehub.bot-customers.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.bot-customers.create',
        'parent_flag' => 'telehub.bot-customers.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.bot-customers.edit',
        'parent_flag' => 'telehub.bot-customers.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.bot-customers.destroy',
        'parent_flag' => 'telehub.bot-customers.index',
    ],
    [
        'name' => 'Top-up Balance',
        'flag' => 'telehub.bot-customers.topup',
        'parent_flag' => 'telehub.bot-customers.index',
    ],
    // Balance Logs
    [
        'name' => 'Balance Logs',
        'flag' => 'telehub.balance-logs.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.balance-logs.create',
        'parent_flag' => 'telehub.balance-logs.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.balance-logs.edit',
        'parent_flag' => 'telehub.balance-logs.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.balance-logs.destroy',
        'parent_flag' => 'telehub.balance-logs.index',
    ],
    // Deposit Requests
    [
        'name' => 'Deposit Requests',
        'flag' => 'telehub.deposit-requests.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.deposit-requests.create',
        'parent_flag' => 'telehub.deposit-requests.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.deposit-requests.edit',
        'parent_flag' => 'telehub.deposit-requests.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.deposit-requests.destroy',
        'parent_flag' => 'telehub.deposit-requests.index',
    ],
    // Bank Webhooks
    [
        'name' => 'Bank Webhooks',
        'flag' => 'telehub.bank-webhooks.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'telehub.bank-webhooks.create',
        'parent_flag' => 'telehub.bank-webhooks.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.bank-webhooks.edit',
        'parent_flag' => 'telehub.bank-webhooks.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'telehub.bank-webhooks.destroy',
        'parent_flag' => 'telehub.bank-webhooks.index',
    ],
    // Orders
    [
        'name' => 'Orders',
        'flag' => 'telehub.orders.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'telehub.orders.edit',
        'parent_flag' => 'telehub.orders.index',
    ],
    // Statistics
    [
        'name' => 'Statistics',
        'flag' => 'telehub.statistics.index',
        'parent_flag' => 'telehub.index',
    ],
    // User Analytics
    [
        'name' => 'User Analytics',
        'flag' => 'telehub.user-analytics.index',
        'parent_flag' => 'telehub.index',
    ],
    // Notifications
    [
        'name' => 'Telegram Notifications',
        'flag' => 'telehub.notifications.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name' => 'Send Notification',
        'flag' => 'telehub.notifications.create',
        'parent_flag' => 'telehub.notifications.index',
    ],
    [
        'name'        => 'Dealers',
        'flag'        => 'telehub.dealers.index',
        'parent_flag' => 'telehub.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'telehub.dealers.create',
        'parent_flag' => 'telehub.dealers.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'telehub.dealers.edit',
        'parent_flag' => 'telehub.dealers.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'telehub.dealers.destroy',
        'parent_flag' => 'telehub.dealers.index',
    ],
    // Manual Deposit
    [
        'name'        => 'Manual Deposit',
        'flag'        => 'telehub.manual-deposit.index',
        'parent_flag' => 'telehub.index',
    ],
    // Convert Data
    [
        'name'        => 'Convert Data',
        'flag'        => 'telehub.convert-data.index',
        'parent_flag' => 'telehub.index',
    ],
    // API Providers
    [
        'name'        => 'Kết Nối API (Kho sỉ)',
        'flag'        => 'telehub.api-providers.index',
        'parent_flag' => 'telehub.index',
    ],
];

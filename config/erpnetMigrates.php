<?php

return [
    'tables' => [
        /*
         * Config example
         *
         * 'table_name' => [
         *  'bindInterface' => 'ExampleInterface',
         *  'bindRepository' => 'ExampleRepository',
         *  'routeController' => 'ExampleController',
         *  'routeLinkName' => 'Example',
         *  'routePrefix' => 'example',
         *  'fields' => [
         *      'field1',
         *      'field2',
         *   ],
         * ],
         */
//        'users' => [
//            'fields' => [
//                'mandante',
//                'name',
//                'avatar',
//                'password',
//                'username',
//                'email',
//                'provider',
//                'provider_id',
//                'activation_code',
//                'active',
//            ],
//        ],
        'orders' => [
//            'transformPresenter' => [
//                'id' => function(\Illuminate\Database\Eloquent\Model $model){ return (int) $model->id; },
//            ],
            'fields' => [
                'id' => [
                    'header' => true,
                    'customShow' => function ($item) {
                        $formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY);
                        $header = \Carbon\Carbon::parse($item['posted_at'])->formatLocalized('%d/%m/%Y %X');
                        $total = 0;
                        foreach ($item['orderItems'] as $orderItem) {
                            $total = $total + ($orderItem['quantidade'] * $orderItem['valor_unitario']);
                        }
                        $header = $header . ' ' . t('Total') . ': ' . $formatter->format($total);

                        return $header;
                    },
                ],
                'mandante',
                'currency_id' => [
//                    'label' => t('Partner'),
                    'customShow' => function ($item) {
                        return $item['sharedCurrency']['nome_universal'].' - '.$item['sharedCurrency']['descricao'];
                    },
                ],
                'type_id' => [
//                    'label' => t('Partner'),
                    'customShow' => function ($item) {
                        return $item['sharedOrderType']['descricao'];
                    },
                ],
                'payment_id' => [
//                    'label' => t('Partner'),
                    'customShow' => function ($item) {
                        return $item['sharedOrderPayment']['descricao'];
                    },
                ],
                'partner_id' => [
//                    'label' => t('Partner'),
                    'customShow' => function ($item) {
                        return $item['partner']['nome'];
                    },
                ],
                'address_id' => [
//                    'label' => t('Address'),
                    'customShow' => function ($item) {
                        $address = $item['address']['cep'] . ' - ' . $item['address']['logradouro'] . ', ' . $item['address']['numero'];

                        if (!empty($item['address']['complemento']))
                            $address = $address . ' - ' . $item['address']['complemento'];

                        if (!empty($item['address']['obs']))
                            $address = $address . ' (' . $item['address']['obs'] . ')';
                        return $address;
                    },
                ],
                'posted_at',
                'orderSharedStats' => [
//                    'label' => t('Status'),
                    'customShow' => function ($item) {
                        if (count($item['orderSharedStats']) > 0) {
                            $line = '';
                            foreach ($item['orderSharedStats'] as $orderSharedStat) {
                                $line = $line . $orderSharedStat['descricao'] . ', ';
                            }
                            return substr($line, 0, -2);
                        } else
                            return t('No Status');
                    },
                ],
                'orderItems' => [
//                    'label' => t('Items'),
                    'customShow' => function ($item) {
                        if (count($item['orderItems']) > 0) {
                            $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
                            $line = '';
                            $total = 0;
                            foreach ($item['orderItems'] as $orderItem) {
                                $total = $total + ($orderItem['quantidade'] * $orderItem['valor_unitario']);
                                $line = $line . '<li>' . $orderItem['product']['nome'] . ' - ' . $orderItem['quantidade'] . 'x ' . $formatter->format($orderItem['valor_unitario']) . '</li>';
                            }
//                        $line = $line . '<li>'. t('Total') . ': ' . $formatter->format($total) . '</li>';
                            return '(' . t('Total') . ': <strong>' . $formatter->format($total) . '</strong>)<ul>' . $line . '</ul>';
                        } else
                            return t('No Items');
                    },
                ],
                'observacao',
            ],
        ],
//        'mandantes' => [
//            'fields' => [
//                'mandante',
//            ],
//        ],
        'partners' => [
            'fields' => [
                'id' => [
                    'header' => true,
                    'customShow' => function ($item) {
                        return $item['nome'];
                    },
                ],
                'mandante',
                'nome',
                'partnerSharedStats' => [
//                    'label' => t('Status'),
                    'customShow' => function ($item) {
                        if (count($item['partnerSharedStats']) > 0) {
                            $line = '';
                            foreach ($item['partnerSharedStats'] as $sharedStat) {
                                $line = $line . $sharedStat['descricao'] . ', ';
                            }
                            return substr($line, 0, -2);
                        } else
                            return t('No Status');
                    },
                ],
            ],
        ],
        'product_groups' => [
            'routeLinkName' => 'Product Groups',
            'fields' => [
                'mandante',
                'grupo',
                'icone',
            ],
        ],
        'products' => [
//            'transformPresenter' => [
//                'id' => function(\Illuminate\Database\Eloquent\Model $model){ return (int) $model->id; },
//                'nome' => function(\Illuminate\Database\Eloquent\Model $model){ return $model->nome; },
//            ],
            'fields' => [
                'id' => [
                    'header' => true,
                    'customShow' => function ($item) {
                        return $item['nome'];
                    },
                ],
                'mandante',
                'nome',
            ],
        ],
        'addresses' => [
            'fields' => [
                'mandante',
                'cep',
                'logradouro',
                'numero',
                'complemento',
                'bairro',
            ],
        ],
        'attachments' => [
            'fields' => [
                'order_id',
                'mandante',
                'file',
            ],
        ],
        'item_orders' => [
            'fields' => [
                'mandante',
                'quantidade',
                'valor_unitario',
                'cost_id',
                'product_id',
            ],
        ],
        'shared_stats' => [
            'fields' => [
                'status',
                'descricao',
            ],
        ],
        'shared_order_types' => [
            'fields' => [
                'tipo',
                'descricao',
            ],
        ],
        'shared_order_payments' => [
            'fields' => [
                'pagamento',
                'descricao',
            ],
        ],
        'shared_currencies' => [
            'fields' => [
                'nome_universal',
                'descricao',
            ],
        ],
//        'pages' => [
//            'fields' => [
//                'ordem',
//                'rota',
//                'nome',
//                'h1',
//                'h2',
//                'view',
//                'conteudo',
//            ],
//        ],
        'sessions' => [
            'fields' => [
                'user_id',
                'ip_address',
                'user_agent',
                'payload',
                'last_activity',
            ],
        ],
//        'posts' => [
////            'transformPresenter' => [
////                'id' => function(\Illuminate\Database\Eloquent\Model $model){ return (int) $model->id; },
////            ],
//            'fields' => [
//                'mandante' => ['value' => 'testesdivertidos'],
//                'title'=> ['customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return link_to_route('post.show', $item['title'], [$item], ['title'=>'Abrir '.$item['title']]); }],
//                'titleSlug',
//                'description',
//                'hint',
//                'paramName'=>['component' => 'widgetCheckbox', 'value' => '1', 'label' => 'Mostrar Nome do Perfil'],
//                'paramFirstName'=>['component' => 'widgetCheckbox', 'value' => '1', 'label' => 'Mostrar Somente Primeiro Nome do Perfil'],
//                'paramNameSize'=>['attributes' => ['placeholder' => 'ex.: 10'], 'label' => 'Tamanho do Nome do Perfil'],
//                'paramNameColor'=>['attributes' => ['placeholder' => 'ex.: FFFFFF'], 'label' => 'Cor do Nome do Perfil'],
//                'paramNameX'=>['attributes' => ['placeholder' => 'ex.: 270'], 'label' => 'Posição X do Nome do Perfil'],
//                'paramNameY'=>['attributes' => ['placeholder' => 'ex.: 230'], 'label' => 'Posição Y do Nome do Perfil'],
//                'paramProfileImageSize'=>['attributes' => ['placeholder' => 'ex.: 116x116'], 'label' => 'Tamanho da Imagem do Perfil'],
//                'paramProfileImageX'=>['attributes' => ['placeholder' => 'ex.: 10'], 'label' => 'Posição X da Imagem do Perfil'],
//                'paramProfileImageY'=>['attributes' => ['placeholder' => 'ex.: 20'], 'label' => 'Posição Y da Imagem do Perfil'],
//                'file'=>['component' => 'widgetFile', 'label' => 'Imagem Antes do Teste', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file'); }],
//                'file1' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 1', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file1'); }],
//                'file2' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 2', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file2'); }],
//                'file3' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 3', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file3'); }],
//                'file4' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 4', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file4'); }],
//                'file5' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 5', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file5'); }],
//                'file6' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 6', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file6'); }],
//                'file7' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 7', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file7'); }],
//                'file8' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 8', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file8'); }],
//                'file9' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 9', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file9'); }],
//                'file10' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 10', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file10'); }],
//                'file11' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 11', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file11'); }],
//                'file12' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 12', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file12'); }],
//                'file13' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 13', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file13'); }],
//                'file14' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 14', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file14'); }],
//                'file15' => ['component' => 'widgetFile', 'label' => 'Imagem Aleatória do Teste 15', 'customShow'=> function(\ErpNET\Models\v1\Entities\PostEloquent $item){ return $item->fileImageField('file15'); }],
//            ],
//
//        ],
    ],
];
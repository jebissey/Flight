<?php return array(
    'root' => array(
        'name' => '__root__',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => null,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        '__root__' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => null,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'flightphp/core' => array(
            'pretty_version' => 'v3.13.1',
            'version' => '3.13.1.0',
            'reference' => 'da6540bbdd3b64a28de0606da7b530d0013f281c',
            'type' => 'library',
            'install_path' => __DIR__ . '/../flightphp/core',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'mikecao/flight' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '2.0.2',
            ),
        ),
    ),
);

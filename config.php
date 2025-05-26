<?php

return [
    'sourcePath'   => __DIR__,    // a gyökér könyvtár, ahonnan összegyűjti a script a fordításokat
    'languages'    => ['en-US', 'hu-HU', 'fr-FR'],   // a nyelvek listája, amire fordítani szeretnél
    'translator'   => 'Yii::t',   // a használt fordító függvény
    'sort'         => false,            // rendezze-e az üzeneteket
    'removeUnused' => true,    // törölni szeretnéd-e a használaton kívüli fordításokat
    'only'         => ['*.php'],        // azok a fájltípusok, amikben keresi a fordításokat
    'except'       => [               // a kihagyásra kerülő könyvtárak és fájlok
                                      '.svn',
                                      '.git',
                                      '.gitignore',
                                      '.gitkeep',
                                      '.hgignore',
                                      '.hgkeep',
                                      '/messages',
                                      '/web/uploads',
    ],
    'format'      => 'php',          // a fordítások formátuma
    'messagePath' => __DIR__ . '/messages', // a fordítások helye
    'overwrite'   => true,        // felülírja-e a már létező fordításokat
];

<?php

return [
	'alias' => [
        'SetTable' => app\admin\http\middleware\SetTable::class,
		'UpTable'  => app\admin\http\middleware\UpTable::class,
		'SetField'  => app\admin\http\middleware\SetField::class,
		'UpField'  => app\admin\http\middleware\UpField::class,
		'DeleteField'  => app\admin\http\middleware\DeleteField::class,
		'DeleteMenu'  => app\admin\http\middleware\DeleteMenu::class,
		'DeleteApplication'  => app\admin\http\middleware\DeleteApplication::class,
    ],
];

<?php

arch('models')->expect('App\Models')->toUse(\Illuminate\Database\Eloquent\Factories\HasFactory::class);

arch('controllers')->expect('App\Http\Controllers')->toBeClasses();

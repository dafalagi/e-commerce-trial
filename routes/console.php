<?php

use Illuminate\Support\Facades\Schedule;

/** File System */
Schedule::command('file-system:delete-old-unused-files')->timezone('Asia/Jakarta')->monthlyOn(1, '00:25'); // Delete old unused files on the first day of every month at 00:25 AM

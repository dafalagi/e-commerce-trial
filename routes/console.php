<?php

use Illuminate\Support\Facades\Schedule;

/** File System */
Schedule::command('file-system:delete-old-unused-files')->timezone('Asia/Jakarta')->monthlyOn(1, '00:25'); // Delete old unused files on the first day of every month at 00:25 AM

/** Sales Reports */
Schedule::command('report:daily-sales')->timezone('Asia/Jakarta')->dailyAt('19:00'); // Send daily sales report every day at 7:00 PM

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function backupDatabase()
    {
        // Simple fallback backup method via querying tables since mysqldump might not be accessible
        $tables = DB::select('SHOW TABLES');
        $dbName = DB::connection()->getDatabaseName();
        $tableKey = 'Tables_in_' . $dbName;
        
        $sql = "-- Portfolio Database Backup\n";
        $sql .= "-- Generated: " . now()->toDateTimeString() . "\n\n";
        
        foreach ($tables as $tableObj) {
            $table = $tableObj->$tableKey;
            
            // Get create table syntax
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0]->{'Create Table'};
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $createTable . ";\n\n";
            
            // Get rows
            $rows = DB::table($table)->get();
            if ($rows->count() > 0) {
                $sql .= "-- Data for {$table}\n";
                foreach ($rows as $row) {
                    $rowArray = (array)$row;
                    $columns = array_map(function($val) {
                        if ($val === null) return 'NULL';
                        return "'" . addslashes($val) . "'";
                    }, array_values($rowArray));
                    
                    $columnsList = implode(', ', array_keys($rowArray));
                    $valuesList = implode(', ', $columns);
                    
                    $sql .= "INSERT INTO `{$table}` (`{$columnsList}`) VALUES ({$valuesList});\n";
                }
                $sql .= "\n\n";
            }
        }
        
        $fileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        Storage::disk('local')->put('backups/' . $fileName, $sql);
        
        return Storage::disk('local')->download('backups/' . $fileName);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use EaseAppPHP\HighPer\Framework\Concurrency\Database\Model;

class User extends Model
{
    protected static string $table = 'users';
    protected static string $primaryKey = 'id';
    
    /**
     * Get users with a specific role
     *
     * @param string $role The role
     * @return array Users with the role
     */
    public static async function findByRole(string $role): array
    {
        $data = await static::$db->query(
            "SELECT * FROM " . static::$table . " WHERE role = ?",
            [$role]
        );
        
        $users = [];
        foreach ($data as $item) {
            $users[] = new static($item);
        }
        
        return $users;
    }
}
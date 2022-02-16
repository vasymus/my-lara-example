<?php

namespace Domain\Common\Models;

trait CommonTraits
{
    public function getFullTableName()
    {
        return $this->getConnection()->getTablePrefix() . $this->getTable();
    }

    public function getConnectionName()
    {
        if (! is_null($this->connection)) {
            return $this->connection;
        }

        return config("database.default");
    }
}

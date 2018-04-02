<?php

namespace Richardds\ServerAdmin\Core\Database;

interface DatabasePermission {
    public const SELECT = 'SELECT';
    public const INSERT = 'INSERT';
    public const UPDATE = 'UPDATE';
    public const DELETE = 'DELETE';
    public const CREATE = 'CREATE';
    public const DROP = 'DROP';
    public const REFERENCES = 'REFERENCES';
    public const INDEX = 'INDEX';
    public const ALTER = 'ALTER';
    public const CREATE_TMP_TABLE = 'CREATE_TMP_TABLE';
    public const LOCK_TABLES = 'LOCK_TABLES';
    public const CREATE_VIEW = 'CREATE_VIEW';
    public const SHOW_VIEW = 'SHOW_VIEW';
    public const CREATE_ROUTINE = 'CREATE_ROUTINE';
    public const ALTER_ROUTINE = 'ALTER_ROUTINE';
    public const EXECUTE = 'EXECUTE';
    public const EVENT = 'EVENT';
    public const TRIGGER = 'TRIGGER';
}

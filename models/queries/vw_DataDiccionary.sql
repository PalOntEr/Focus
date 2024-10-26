-- Data Dictionary View for Tables

CREATE OR REPLACE VIEW DataDictionary AS
SELECT 
    TABLE_NAME AS 'Table Name',
    COLUMN_NAME AS 'Column Name',
    COLUMN_TYPE AS 'Data Type',
    IS_NULLABLE AS 'Is Nullable',
    CASE 
        WHEN COLUMN_KEY = 'PRI' THEN 'Primary Key'
        WHEN COLUMN_KEY = 'UNI' THEN 'Unique'
        WHEN COLUMN_KEY = 'MUL' THEN 'Compound Key'
        ELSE 'Not a key'
    END AS 'Key',
    COLUMN_DEFAULT AS 'Default Value',
    EXTRA AS 'Extra',
    COLUMN_COMMENT AS 'Comment'
FROM 
    INFORMATION_SCHEMA.COLUMNS
WHERE 
    TABLE_SCHEMA = 'db_bdm'
    AND TABLE_NAME NOT LIKE '%columndetails%'
    AND TABLE_NAME NOT LIKE '%datadictionary%'
ORDER BY 
    TABLE_NAME, 
    ORDINAL_POSITION;
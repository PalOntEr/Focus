DROP VIEW IF EXISTS vw_PurchaseReport;

CREATE VIEW vw_PurchaseReport AS
SELECT
    u.userId,
    u.fullName,
    p.purchaseId,
    p.purchaseDate,
    p.paymentAmount,
    p.courseId,
    p.levelId,
    p.paymentMethod,
    p.paymentType,
    CASE p.paymentType
        WHEN 'L' THEN 'LEVEL BASED'
        WHEN 'C' THEN 'COURSE BASED'
        ELSE 'UNKNOWN'
    END AS paymentTypeText,
    l.levelNumber,
    IFNULL(l.levelNumber, 'ALL LEVELS') AS levelNumberText
FROM
    Purchases p
    LEFT JOIN Levels l ON l.levelId = p.levelId
    JOIN Users u ON u.userId = p.userId
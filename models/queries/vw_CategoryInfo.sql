DROP VIEW IF EXISTS CategoryInfo;

CREATE VIEW CategoryInfo AS
SELECT `categoryId`,`categoryName`,`categoryDescription`,u.`fullName`, c.`creationDate`
 FROM categories c JOIN users u ON c.`creatorId` = U.`userId`
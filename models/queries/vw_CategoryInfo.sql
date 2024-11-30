DROP VIEW IF EXISTS CategoryInfo;

CREATE VIEW CategoryInfo AS
SELECT `categoryId`,`categoryName`,`categoryDescription`,u.`fullName`, c.`creationDate`, c.`deactivationDate`
 FROM categories c JOIN users u ON c.`creatorId` = U.`userId`
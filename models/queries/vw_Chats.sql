-- User chats view

DROP VIEW IF EXISTS vw_Chats;

CREATE VIEW vw_Chats AS
SELECT 
    sender.userId AS senderId,
    sender.username AS senderUsername,
    receiver.userId AS receiverId,
    receiver.username AS receiverUsername
FROM 
    Messages m
JOIN 
    Users sender ON m.senderId = sender.userId
JOIN 
    Users receiver ON m.receiverId = receiver.userId
GROUP BY 
    sender.userId, sender.username, receiver.userId, receiver.username;
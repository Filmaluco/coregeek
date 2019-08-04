SELECT 	ORs.OR_ID,
        Repair_State.Name as Estado,
        CONCAT(Last_Repair.Brand, ' ',Last_Repair.Model) AS Dispositivo,
        Clients.Name AS Cliente,
        CONCAT(Clients.Email, '/', Clients.Phone) AS 'Contactos',
        CONCAT(DATE_FORMAT(t.Creation_Date, "%d, %M %Y"), ' por ', Users.Username) as UltimaAlteracao
FROM ORs
       JOIN (SELECT  a.*
             FROM    OR_State a
                       INNER JOIN
                         (
                         SELECT  State_ID, MAX(Creation_Date)maxDate
                         FROM OR_State
                         GROUP BY OR_ID
                         ) b  WHERE
                 a.Creation_Date = b.maxDate) t
         ON ORs.OR_ID = t.OR_ID
       JOIN Repair_State
         ON t.State_ID = Repair_State.State_ID
       JOIN (
            SELECT  OR_ID,
                    Repair_Info.Creation_Date,
                    Brand,
                    Model
            FROM Repair_Info
                   JOIN (SELECT Repair_ID, Max(Creation_Date) FROM Repair_Info GROUP BY Repair_ID) as B
                     ON Repair_Info.Repair_ID = B.Repair_ID
            GROUP BY OR_ID
            ) AS Last_Repair
         ON t.OR_ID = Last_Repair.OR_ID
       JOIN Clients ON ORs.Client_ID = Clients.Client_ID
       JOIN Users ON t.User_ID = Users.User_ID
WHERE t.State_ID < 14 ORDER BY ORs.OR_ID

-- inferior a 14 pois >= 14 esta entregue
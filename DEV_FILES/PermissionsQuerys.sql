SELECT DISTINCT Permissions.PermisionName
FROM Permissions
LEFT JOIN GroupPermissions
on Permissions.PermisionID = GroupPermissions.PermissionID
and GroupPermissions.GroupID in (
    	SELECT Groups.GroupID 
    	FROM Groups
    	LEFT JOIN UserGroups
    	on Groups.GroupID = UserGroups.GroupID
        and UserGroups.UserID in (    
        	SELECT Users.UserID 
            FROM Users
            WHERE Users.UserName = 'AndrePaixao'
        ) 
)
WHERE NOT PermissionID in (
    SELECT UserPremissionsOverrides.PermissionID
	FROM UserPremissionsOverrides
	LEFT JOIN Users
	ON UserPremissionsOverrides.UserID in (
    	SELECT Users.UserID
    	FROM Users
    	WHERE Users.UserName = 'AndrePaixao'
    )
	WHERE NOT UserPremissionsOverrides.IsGranted = 1
)


--Para negativo esta a funcionar, ver se exceçoes positivas dao... pretty sure it doesn't


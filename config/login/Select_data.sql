#View All Requests
SELECT * FROM Request;

#View All Locations
SELECT * FROM Location;

#View Requests WITH Location Details
SELECT 
    r.req_id,
    r.req_name,
    r.req_type,
    r.status,
    l.province,
    l.district,
    l.street
FROM Request r
JOIN Location l ON r.loc_id = l.loc_id;

#Get Only Pending Requests
SELECT * FROM Request
WHERE status = 'Pending';

#Get High Priority Requests
SELECT * FROM Request
WHERE priority = 'High';

#Get Requests from a Specific District
SELECT r.req_name, r.req_type, l.district
FROM Request r
JOIN Location l ON r.loc_id = l.loc_id
WHERE l.district = 'Galle';

#Count Total Requests
SELECT COUNT(*) AS total_requests FROM Request;

#Count Requests by Type
SELECT req_type, COUNT(*) AS total
FROM Request
GROUP BY req_type;

#Count Requests by District
SELECT l.district, COUNT(*) AS total_requests
FROM Request r
JOIN Location l ON r.loc_id = l.loc_id
GROUP BY l.district;

#Latest Requests (Recent First)
SELECT * FROM Request
ORDER BY created_at DESC;

#Requests with Location (Full Details)
SELECT *
FROM Request r
JOIN Location l ON r.loc_id = l.loc_id;
INSERT INTO Location (latitude, longitude, province, district, street) VALUES
(6.9271, 79.8612, 'Western', 'Colombo', 'Galle Road'),
(7.2906, 80.6337, 'Central', 'Kandy', 'Peradeniya Road'),
(6.0535, 80.2210, 'Southern', 'Galle', 'Main Street'),
(5.9485, 80.5353, 'Southern', 'Matara', 'Beach Road'),
(7.8731, 80.7718, 'Central', 'Matale', 'Temple Road'),
(6.1241, 81.1185, 'Southern', 'Hambantota', 'Station Road'),
(7.2083, 79.8358, 'Western', 'Gampaha', 'Negombo Road'),
(8.3114, 80.4037, 'North Central', 'Anuradhapura', 'Lake Road'),
(7.4863, 80.3623, 'North Western', 'Kurunegala', 'Clock Tower Street'),
(9.6615, 80.0255, 'Northern', 'Jaffna', 'Hospital Road');

INSERT INTO Request (req_name, req_type, description, contact_number, priority, status, loc_id) VALUES
('Nimal', 'Food', 'Need food for 10 people', '0711111111', 'High', 'Pending', 1),
('Saman', 'Medical', 'Injured person needs help', '0722222222', 'High', 'Pending', 2),
('Kamal', 'Shelter', 'House flooded', '0733333333', 'Medium', 'Pending', 3),
('Sunil', 'Food', 'No food for 2 days', '0744444444', 'High', 'Pending', 4),
('Amal', 'Medical', 'Child is sick', '0755555555', 'High', 'Pending', 5),
('Ravi', 'Shelter', 'Need temporary shelter', '0766666666', 'Medium', 'Pending', 6),
('Kasun', 'Food', 'Need dry ration', '0777777777', 'Low', 'Pending', 7),
('Chamara', 'Medical', 'Need medicine urgently', '0788888888', 'High', 'Pending', 8),
('Dinesh', 'Shelter', 'Family displaced', '0799999999', 'Medium', 'Pending', 9),
('Ajith', 'Food', 'No access to food', '0700000000', 'High', 'Pending', 10);
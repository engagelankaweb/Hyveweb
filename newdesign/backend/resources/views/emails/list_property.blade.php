<h2>New Property Listing Submission</h2>
<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Contact Number:</strong> {{ $data['contact_number'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Property Type:</strong> {{ $data['property_type'] }}</p>
<p><strong>Location:</strong> {{ $data['location'] }}</p>
<p><strong>Description:</strong> {{ $data['description'] }}</p>
<p><strong>Additional Notes:</strong> {{ $data['additional_notes'] ?? 'N/A' }}</p>

<p>A new contact form has been submitted:</p>
<table>
    <tr>
        <td>ID</td>
        <td>{{ $contact->id }}</td>
    </tr>
    <tr>
        <td>Name</td>
        <td>{{ $contact->name }}</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>{{ $contact->email }}</td>
    </tr>
   
    <tr>
        <td>Submitted At</td>
        <td>{{ $contact->created_at }}</td>
    </tr>
</table>
<style>
    table, td, th {  
        border: 1px solid #ddd;
        text-align: left;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        padding: 15px;
        text-align: left;
    }
</style>

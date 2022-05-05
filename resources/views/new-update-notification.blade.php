<p>
    Hello. A new update has been requested. The details have been stated below. Kindly login to your account to confirm or decline this request. Thanks and Regards. <br>

</p>
<p>
    <b>User Name:</b> {{ data_get($update, 'user.first_name')." ".data_get($update, 'user.last_name') }}<br>
    <b>User Reference:</b> {{ data_get($update, 'user.reference') }}<br>
    <b>User Email:</b> {{ data_get($update, 'user.email') }}<br>
    <b>Requested By:</b> {{ data_get($update, 'requested_by.first_name')." ".data_get($update, 'requested_by.last_name') }}<br>
    <b>Request Type:</b> {{ data_get($update, 'type') }}<br>
    <b>Request Details:</b><br>
    @foreach(data_get($update, 'details') as $key => $detail)
        {{ "$key: $detail" }}<br>
    @endforeach
    <b>Created At:</b> {{ data_get($update, 'created_at')->toDayDateTimeString() }}<br>
</p>

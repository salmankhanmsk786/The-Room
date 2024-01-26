document.addEventListener('DOMContentLoaded', function() {
    fetchGroupInfo();
});

function fetchGroupInfo() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_group_info.php' + window.location.search, true);
    


    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                displayGroupInfo(response.groupInfo);
            } else {
                console.error('Error fetching group info:', response.message);
            }
        } else {
            console.error('The request failed with status:', xhr.status, xhr.statusText);
        }
    };

    xhr.onerror = function () {
        console.error('There was an error making the request.');
    };

    xhr.send();
}


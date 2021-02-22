$(document).ready(function (){
    console.log('jquery ready');

    $(document).on('click' , '*[generate-random-accounts]', function (){
        generateAccountRequest($(this).attr('generate-random-accounts'));
    });
});



async function generateAccountRequest (totalAccounts){
    const { value: accountCount } = await Swal.fire({
        title: 'Enter Number of accounts to generate',
        input: 'number',
        inputValue:totalAccounts,
        inputLabel: 'Number of accounts',
        showCancelButton: true,
        inputValidator: (value) => {
            if (!value) {
                Swal.fire('info','Please provide a valid number' , 'info').then( () => {
                    generateAccountRequest(totalAccounts);
                });
            }
        }
    });

    if (accountCount) {
        data.accountCount = accountCount;
        $.ajax({
            type: "post",
            url: ajaxUrl + 'api/v1/accounts',
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
    
            success: (response) => {
                if(response.status == 200){
                 console.log('response' , response);
                }else{
                    Swal.fire({
                        icon: 'error',
                        text: 'Unable to create account at the moment.',
                    });
                }
    
            },
            error: (error) => {
                console.log('error',error);
            },
            beforeSend: () => {
    
            },
            complete: (data) => {
    
            }
        });
    }

}
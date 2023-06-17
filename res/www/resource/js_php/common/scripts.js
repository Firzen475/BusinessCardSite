$(document).ready(function(){
    console.log("dock ready");
    tmp();
    user_info();
    get_pg_credentials();
    df();
    refresh_file_list();
    get_ftp_credentials();

})

$(window).scroll(function(){
    navigation_active();
})
function downloadPresentation(video, resolution) {
    $(document).ajaxStart(function(){
        // Show spinner
        Livewire.emit('showModal', video);
    });
    $(document).ajaxComplete(function(){
        // Hide spinner
        Livewire.emit('doClose');
        window.location = '/download_zip/'+video;
    });
    // Download
    $.get('/download/'+video+'?res='+resolution, function(data){
        $(".result").html(data);
    });
}

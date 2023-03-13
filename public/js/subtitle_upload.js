Dropzone.options.subtitleupload =
    {
        //Settings file for a custom subtitle .vtt file upload
        paramName: "subtitle",
        parallelUploads: 1,  // since we're using a global 'currentFile', we could have issues if parallelUploads > 1, so we'll make it = 1
        maxFilesize: 50000000,   // max individual file size
        maxFiles: 1, // max 1 file
        chunking: true,      // enable chunking
        forceChunking: true, // forces chunking when file.size < chunkSize
        parallelChunkUploads: true, // allows chunks to be uploaded in parallel (this is independent of the parallelUploads option)
        chunkSize: 5000000,  // chunk size 10,000,000 bytes (~10MB)
        retryChunks: true,   // retry chunks on failure
        retryChunksLimit: 5, // retry maximum of 5 times
        acceptedFiles: "text/vtt",
        addRemoveLinks: true,
        timeout: 0,
        init: function() {
            this.on("addedfile", file => {
                console.log("A file has been added:"+file.name);
            });
        },

        maxfilesexceeded: function(file) {
            alert("Maximum files uploadlimit reached");
            this.removeFile(file);
        },

        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+"_"+file.name;
        },
        removedfile: function(file) {
            var name = file.upload.filename;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: deleteSubtitle,
                data: {
                    filename: name,
                    localdir: subtitledir,
                },
                success: function (data){
                    console.log("File has been successfully removed!!");
                },
                error: function(e) {
                    console.log(name, e);
                }
            });
            var fileRef;

            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        }
    };

Dropzone.options.datanodeupload =
    {
        parallelUploads: 1,  // since we're using a global 'currentFile', we could have issues if parallelUploads > 1, so we'll make it = 1
        maxFilesize: 50000000,   // max individual file size
        maxFiles: 4,
        chunking: true,      // enable chunking
        forceChunking: true, // forces chunking when file.size < chunkSize
        parallelChunkUploads: true, // allows chunks to be uploaded in parallel (this is independent of the parallelUploads option)
        chunkSize: 10000000,  // chunk size 10,000,000 bytes (~10MB)
        retryChunks: true,   // retry chunks on failure
        retryChunksLimit: 5, // retry maximum of 5 times
        maxfilesexceeded: function(file) {
            alert("Maximum files uploadlimit reached");
            this.removeFile(file);
        },

        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+"_"+file.name;
        },
        acceptedFiles: "video/*",
        addRemoveLinks: true,
        timeout: 0,
        removedfile: function(file) {
            var name = file.upload.filename;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: deleteAction,
                data: {
                    filename: name,
                    localdir: dir,
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

        /*success: function(file, response)
        {
            //Select the preview element
            var previewImg = file.previewElement.querySelector('img');

            var newImagePath = file.name;
            newImagePath = "images/su_template.gif";
            previewImg.src = newImagePath;

        }*/

    };


Dropzone.options.datanodeupload =
    {
        //Settings file for video upload
        parallelUploads: 1,  // since we're using a global 'currentFile', we could have issues if parallelUploads > 1, so we'll make it = 1
        maxFilesize: 50000000,   // max individual file size
        maxFiles: 4, // max files
        chunking: true,      // enable chunking
        forceChunking: true, // forces chunking when file.size < chunkSize
        parallelChunkUploads: true, // allows chunks to be uploaded in parallel (this is independent of the parallelUploads option)
        chunkSize: 10000000,  // chunk size 10,000,000 bytes (~10MB)
        retryChunks: true,   // retry chunks on failure
        retryChunksLimit: 5, // retry maximum of 5 times

        init: function() {
            var bt = document.getElementById('submit');
            this.on("complete", function(file) {
                Livewire.emit('fileAdded')
                //Check number of files before enabling submit button
                if(this.files.length > 0) {
                    bt.disabled = false;
                }
                console.log("A file has been added:"+file.name);
            });
        },

        maxfilesexceeded: function(file) {
            var bt = document.getElementById('submit');
            alert("Maximum files uploadlimit reached");
            if(this.files.length > 4) {
                bt.disabled = true;
            }
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
            var bt = document.getElementById('submit');
            //Upload files status
            Livewire.emit('fileRemoved')
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
            //Check number of files before enabling submit button
            if(this.files.length > 0) {
                bt.disabled = false;
            } else {
                bt.disabled = true;
            }
            return (fileRef = file.previewElement) != null ?
                fileRef.parentNode.removeChild(file.previewElement) : void 0;
        }
    };


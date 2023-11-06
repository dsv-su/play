Dropzone.options.datanodeupload =
    {
        //Settings file for video upload
        parallelUploads: 1,  // since we're using a global 'currentFile', we could have issues if parallelUploads > 1, so we'll make it = 1
        maxFilesize: 50000000,   // max individual file size
        maxFiles: 4, // max files
        chunking: true,      // enable chunking
        forceChunking: true, // forces chunking when file.size < chunkSize
        parallelChunkUploads: true, // allows chunks to be uploaded in parallel (this is independent of the parallelUploads option)
        //chunkSize: 20000000,  // chunk size 20,000,000 bytes (~20MB)
        chunkSize: 2000000,  // chunk size 20,000,000 bytes (~2MB)
        retryChunks: true,   // retry chunks on failure
        retryChunksLimit: 5, // retry maximum of 5 times

        init: function() {
            var bt = document.getElementById('submit');
            this.on("complete", function(file) {
                Livewire.emit('fileAdded')
                console.log("A file has been added:"+file.name);
            });
            this.on("processing", function() {
                console.log("A upload file process has started");
                bt.disabled = true;
            });
            this.on("queuecomplete", function() {
                //Check number of files before enabling submit button
                if(this.files.length > 0) {
                    async function waitforfiles() {
                       //Wait for 5 seconds
                        await new Promise(resolve => setTimeout(resolve, 5000));
                        bt.disabled = false;
                    }
                    waitforfiles();
                }
                console.log("The queue has finished:");
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
            /*var dt = new Date();
            var time = dt.getTime();
            return time+"_"+file.name;*/

            var filenameextension = file.name.replace(/^.*[\\\/]/, '');
            var filename = filenameextension.substring(0, filenameextension.lastIndexOf('.'));
            var ext = filenameextension.split('.').pop();

            var hash = 0, i, chr;
            if (filename.length === 0) return hash;
            for (i = 0; i < filename.length; i++) {
                chr = filename.charCodeAt(i);
                hash = ((hash << 5) - hash) + chr;
                hash |= 0; // Convert to 32bit integer
            }
            return Math.abs(hash) + '.' + ext;


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


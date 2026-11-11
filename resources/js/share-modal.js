window.shareModal = function ({ baseUrl, videoId, defaultSubtitle, thumbUrl }) {
        return {
            modalOpen: false,
            baseUrl,
            videoId,
            thumbUrl,

            // UI selection (changes when radio clicked)
            selectedSubtitle: defaultSubtitle,

            // Actually applied to URL (starts null)
            appliedSubtitle: null,

            applySubtitle() {
                this.appliedSubtitle = this.selectedSubtitle;
            },

            clearSubtitle() {
                this.appliedSubtitle = null;
            },

            get shareUrl() {
                const params = new URLSearchParams();
                params.set('p', this.videoId);

                if (this.appliedSubtitle) {
                    params.set('s', this.appliedSubtitle);
                }

                return `${this.baseUrl}?${params.toString()}`;
            },

            get embedCode() {
                return `<span style="position:relative;display:inline-block;">
  <a target="_blank" href="${this.shareUrl}">
    <span style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:white;">
      <i class="fa fa-play fa-5x" aria-hidden="true"></i>
    </span>
    <img src="${this.thumbUrl}" width="560" height="315" alt="">
  </a>
</span>`;
            },
        };
    };

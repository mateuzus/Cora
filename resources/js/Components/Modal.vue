<template>
    <div
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
        v-show="this.show"
       >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ modaltitle }}</h5>
                    <button type="button" class="close" @click="this.close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="content"></slot>
                </div>
                <slot name="buttons">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="this.close"  data-dismiss="modal">Fechar</button>
                    </div>
                </slot>
            </div>
        </div>
    </div>
</template>

<script>
import Modal from 'bootstrap/js/src/modal';
export default {
    name: 'modal',
    props: {
        modaltitle:{
            type: String,
            default: null
        },
        show: {
            type: Boolean,
            default: false
        },
        onOpen: {
            type: Function,
            default: null
        },
        onClose: {
            type: Function,
            default: null
        }
    },
    mounted() {
        this.modalInstance = new Modal(this.$el);
        // If the esc button is typed, close modal.
        document.addEventListener('keydown', this.handleKeydown);
    },
    data() {
        return {
            modalInstance: null,
        };
    },
    watch: {
        // Watch for a change in show, so we can call for open or close.
        show(value) {
            if (value) {
                this.open()
            } else if ( ! value) {
                this.close()
            }
        }
    },
    beforeDestroy() {
        document.removeEventListener('keydown', this.handleKeydown);
        if (this.isDef(this.modalInstance)) {
            this.modalInstance.dispose();
            this.modalInstance = null;
        }
    },
    methods: {
        handleKeydown(e) {
            if (this.show && e.keyCode === 27) {
                this.close();
            }
        },
        close() {
            if (this.isDef(this.modalInstance)) {
                this.modalInstance.hide();
            }
            // Next, call a defined callback.
            if (this.onClose !== null) {
                this.onClose()
            }
        },
        open() {
            // First, call a defined callback.
            if (this.isDef(this.onOpen)) {
                this.onOpen()
            }
            this.modalInstance.show();
        },
        isDef(obj) {
            return typeof obj !== undefined && obj !== null;
        },
    }
}
</script>

<style scoped>
    .modal-lg{
        width: 90%;
    }
</style>

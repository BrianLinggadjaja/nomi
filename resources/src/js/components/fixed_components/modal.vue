<template>
  <transition v-if="modalVisible" name="modal">
    <div class="modal-mask" >
      <div class="modal__container">
        <div class="modal-header">
          <div class="modal-name">
            <strong>{{this.studentProfile.displayName}}</strong>
          </div>
          <div class="modal--exit">
              <i class="fa fa-times fa-2x modal__exit-button" @click="showModal()"></i>
          </div>
        </div>
        <div class="modal-body">
          <div name="body">
            <modals-carousel></modals-carousel>
          </div>
        </div>
        <div class="modal-footer cf">
          <div v-if="okayToUpdate" name="footer" class="modal-footer" >
            <croppa-functionality v-show="croppaAvailable"></croppa-functionality>	           
          </div>
          <div v-else name="footer" class="modal-footer" >
            <croppa-functionality v-show="!croppaAvailable"></croppa-functionality>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
    import croppaFunctionality from "../profile_components/croppaFunctionality.vue";
    import modalsCarousel from "../profile_components/modalsCarousel.vue";
    import { mapGetters } from 'vuex';
    export default {
      name: 'modal',

        data: function() {
          return{
            croppaAvailable: true,
            okayToUpdate: null
          }
        },

        computed: {
          ...mapGetters(["modalVisible", "studentProfile"])
        },

        created(){
            this.$root.$on('newSlide', () => {
                this.croppaToggle()
                
            });
            this.$root.$on('okayToUpdate', (selected) => {
              this.setUpdate(selected)
            });
        },

        watch: {
          modalVisible() {
            this.update();
          }
        },

        components: {
            croppaFunctionality,
            modalsCarousel
        },
        
        methods: {
          showModal() {
            this.$store.dispatch("toggleModal", false);
            this.$store.dispatch("toggleCropping", false);
            this.croppaAvailable = true;
          },

          setUpdate(selected){
            this.okayToUpdate = selected;
          },

          update() {
            if (this.modalVisible === true)
            {
              this.$store.dispatch("toggleCropping", true);
            } else {
              this.croppaAvailable = true;
            }
          },

          croppaToggle(){
            this.croppaAvailable = !this.croppaAvailable;
          }
        },
    }
</script>




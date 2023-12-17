<template>
    <admin>
        <div class="px-5">
            <h1 class="pb-2">Lista de digimons</h1>
            <template v-if="loading">
                <div class="d-flex justify-content-center align-items-center" v-if="loading">
                    <v-progress-circular :size="45" color="blue-gray" indeterminate />
                </div>
            </template>
            <template v-else-if="listDigimons.length > 0">
                <v-row class="d-flex justify-content-center">
                    <v-col  v-for="digimon in listDigimons" :key="digimon.id" cols="6" md="4" lg="2" @click="openModal(digimon)">
                        <v-img :src="digimon.images[0].href" :lazy-src="digimon.images[0].href" aspect-ratio="1" cover class="cursor bg-grey-lighten-2" />
                        <div class="text-center mt-2">
                            <p>{{ digimon.name }}</p>
                        </div>
                    </v-col>
                    <v-col cols="10" md="10" lg="10">
                        <v-pagination v-model="page" :length="totalPage" rounded="circle"></v-pagination>
                    </v-col>
                </v-row>
            </template>

            <v-dialog v-model="dialog" width="35rem" >
                <v-card>
                    <v-card-text>
                        <div class="d-flex flex-column align-items-center">
                            <span class="text-subtitle-1" v-text="digimonShowModal.id" />
                            <span class="text-h6 font-weight-black text-decoration-underline" v-text="digimonShowModal.name" />
                            <v-img v-if="digimonShowModal && digimonShowModal.images && digimonShowModal.images[0]" 
                                :src="digimonShowModal.images[0].href" :lazy-src="digimonShowModal.images[0].href" aspect-ratio="1" 
                                cover class="cursor bg-grey-lighten-2" />

                            <div class="d-flex flex-row">
                                <div class="d-flex flex-column mx-5 align-items-center">
                                    <span class="text-subtitle-1 font-weight-black">Level</span>
                                    <template v-for="level in digimonShowModal.levels">
                                        <div>
                                            <span v-text="level.level"/>
                                        </div>
                                    </template>
                                </div>
                                <div class="d-flex flex-column mx-5 align-items-center">
                                    <span class="text-subtitle-1 font-weight-black">Attribute</span>
                                    <template v-for="attribute in digimonShowModal.attributes">
                                        <div>
                                            <span v-text="attribute.attribute"/>
                                        </div>
                                    </template>
                                </div>
                                <div class="d-flex flex-column mx-5 align-items-center">
                                    <span class="text-subtitle-1 font-weight-black">Type</span>
                                    <template v-for="getvalor in digimonShowModal.types">
                                        <div>
                                            <span v-text="getvalor.type"/>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <span class="text-subtitle-2 font-weight-black mt-3">Fields</span>
                            <div class="d-flex flex-row mt-3">
                                <template v-for="field in digimonShowModal.fields">
                                    <img class="mr-1" :src="field.image" alt="">
                                </template>

                            </div>
                        </div>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="primary" block @click="dialog = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </admin>
  </template>
  
  <script>
  import admin from '../layouts/Admin.vue';
  
  export default {
    components: { admin },
  
    props: ["users", "roles", "auth", "digimon"],
  
    data() {
      return {
        page: 1,
        totalPage: this.digimon.pageable.totalPages,
        listDigimons: [],
        digimonShowModal: {},
        loading: false,
        dialog: false,
      };
    },
  
    methods: {
      async getApiDigimons() {
        try {
            this.loading = true;
            this.$inertia.get("/digimon", {
                page: this.page
            }, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: async () => {
                    this.listDigimons = [];
                        const requests = this.digimon.content.map(async (element) => {
                            const response = await axios.get(element.href);
                            return response.data;
                        });
                    this.listDigimons = await Promise.all(requests);
                },
            });
        } catch (error) {
          console.error('Error:', error);
        } finally {
            setTimeout(() => {
                this.loading = false;
            }, 1500); 
        }
      },

      openModal(digimon){
        this.dialog = true;
        this.digimonShowModal = digimon;
      }
    },
  
    watch: {
      page: function () {
        this.getApiDigimons();
      }
    },
  
    mounted() {
      this.getApiDigimons();
    },
  };
  </script>

  <style>
  .cursor {
    cursor: pointer;
  }
  </style>
  
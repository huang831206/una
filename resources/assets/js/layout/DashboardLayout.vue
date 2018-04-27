<template>
<v-app id="inspire">
    <v-navigation-drawer fixed right clipped permanent style="margin-top:64px">
        <v-list>
            <message v-for="(marker,index) in markers" :key="marker.id" :page-data="marker"></message>
        </v-list>
    </v-navigation-drawer>
    <v-navigation-drawer fixed clipped class="grey lighten-4" app v-model="drawer" :width="220">
        <v-list dense class="grey lighten-4">
            <template v-for="(item, i) in items">
          <v-layout
            row
            v-if="item.heading"
            align-center
            :key="i"
          >
            <v-flex xs6>
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-right">
              <v-btn small flat>edit</v-btn>
            </v-flex>
          </v-layout>
          <v-divider
            dark
            v-else-if="item.divider"
            class="my-3"
            :key="i"
          ></v-divider>
          <v-list-tile
            :key="i"
            v-else
            @click=""
          >
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="grey--text">
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
        </v-list>
    </v-navigation-drawer>
    <v-toolbar color="amber" app absolute clipped-left>
        <v-toolbar-side-icon @click.native="drawer = !drawer"></v-toolbar-side-icon>
        <span class="title ml-3 mr-5">HelpBell&nbsp;<span class="text">Console</span></span>
        <v-list-tile-avatar><img :src="pageData.icon_url" @click="forge"></v-list-tile-avatar>
        <v-text-field solo-inverted flat label="Search" prepend-icon="search"></v-text-field>
        <v-spacer></v-spacer>
        <div v-if="pageData.isGuest">
            <v-btn small flat :href="pageData.login.url">{{pageData.login.text}}</v-btn>
            <v-btn small flat :href="pageData.register.url">{{pageData.register.text}}</v-btn>
        </div>
        <div v-else>
            <v-menu offset-y>
                <v-btn color="primary" dark slot="activator">
                    {{ user.name }}
                    <v-icon>expand_more</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile @click.prevent="logout">
                        <v-list-tile-title @click="logout">logout</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </div>
    </v-toolbar>
    <v-content>
        <v-container fluid fill-height class="grey lighten-4 pa-0">
            <v-layout justify-center align-center>

                <main-map :markers="this.pageData.messages"></main-map>
                <!-- <div class="">
                    <message page-data="{n:1}"></message>
                </div> -->


                </div>
            </v-layout>
        </v-container>
    </v-content>
</v-app>
</template>

<script>
import Echo from "laravel-echo"
export default {
    data: () => ({
        markers: [
            // {position: {id: 1, lat: 23.5948976, lng: 121.0056306}}
            {
                "id": "1",
                position:{
                    lat: 23.5948976,
                    lng: 121.0056306
                },
                message: {
                    "device": "4D9A83",
                    "time": "1523524028",
                    "duplicate": 0,
                    "snr": "16.38",
                    "rssi": "-127.00",
                    "station": "6D6C",
                    "avgSnr": "19.24",
                    "lat": "23.5948976",
                    "lng": "121.0056306",
                    "radius": 10742,
                    "geolocSource": "2",
                    "seqNumber": 83,
                    "created_at": null,
                    "updated_at": null,
                    "date": "2018-04-12 05:07:08"
                }
            }

        ],
        drawer: null,
        items: [{
                icon: 'lightbulb_outline',
                text: 'Notes'
            },
            {
                icon: 'touch_app',
                text: 'Reminders'
            },
            {
                divider: true
            },
            {
                heading: 'Labels'
            },
            {
                icon: 'add',
                text: 'Create new label'
            },
            {
                divider: true
            },
            {
                icon: 'archive',
                text: 'Archive'
            },
            {
                icon: 'delete',
                text: 'Trash'
            },
            {
                divider: true
            },
            {
                icon: 'settings',
                text: 'Settings'
            },
            {
                icon: 'chat_bubble',
                text: 'Trash'
            },
            {
                icon: 'help',
                text: 'Help'
            },
            {
                icon: 'phonelink',
                text: 'App downloads'
            },
            {
                icon: 'keyboard',
                text: 'Keyboard shortcuts'
            }
        ]
    }),
    props: {
        user: {},
        pageData: {
            messages:[]
        },
        source: String
    },
    methods: {
        logout() {
            console.log('attempt to logout');
            document.getElementById('logout-form').submit();
        },
        addMessage(event) {
            let exists = this.markers.find((o) => {
                return o.id == event.id
            });
            if (exists) {
                console.log('incoming duplicate message, id: ' + event.id);
                return;
            }
            event.position = {
                lat: parseFloat(event.message.lat),
                lng: parseFloat(event.message.lng)
            };
            event.message.date = window.moment.unix(event.message.time).format('YYYY-MM-DD hh:mm:ss');
            console.log(event);
            this.markers.push(event);
            this.pageData.messages = this.markers;

            alertify.closeLogOnClick(true).error('收到求救訊號：序號' + event.message.seqNumber);
        },
        add: function(){
            console.log('add');
        },
        forge() {
            axios.get('/api/message/forge');
        }
    },
    mounted() {
        this.markers = this.pageData.messages;
        var vm = this;
        window.Echo = new Echo({
            broadcaster: 'socket.io',
            host: window.location.hostname + ':6001'
        });

        window.Echo.join('dashboard')
            .listenForWhisper('typing', function(event) {
                console.log('he/she is typing');
            })
            .listen('MessageReceived', function(event) {
                console.log('MessageReceived: ');
                console.log(event);
                vm.addMessage(event);
            });

        console.log('GO!');
    }
}
</script>

<style>
#keep main .container {
    height: 660px;
}

.navigation-drawer__border {
    display: none;
}

.text {
    font-weight: 400;
}

.alertify-logs {
    z-index: 9999;
}
</style>

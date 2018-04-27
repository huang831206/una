<template>
    <gmap-map
        id="map-area"
        :center="center"
        :zoom="zoom"
        style="width: 100%; height: 100%">
        <gmap-marker
            v-for="m in markers"
            :key="m.id"
            :position="m.position"
            :clickable="true"
            :draggable="false"
            @click="toggleInfoWindow(m)">
        </gmap-marker>
        <gmap-info-window
            :options="infoOptions"
            :position="infoPosition"
            :opened="infoOpened"
            @closeclick="infoOpened=false">
            發送時間：{{infoContent.message.date}}<br>
            持有人：<br>
            裝置編號：{{infoContent.message.device}}<br>
            緯度：{{infoContent.message.lat}}<br>
            經度：{{infoContent.message.lng}}<br>
            範圍：{{infoContent.message.radius}}公尺<br>
            發送序號：{{infoContent.message.seqNumber}}<br>

        </gmap-info-window>
    </gmap-map>
</template>

<script>
    export default {
        props: {
            markers:{}
        },
        data : ()=>({
            center : {lat: 23.5948976, lng: 121.0056306},
            zoom:8,
            infoContent: {
                message:{
                    date: '',
                    device:' ',
                    lat: '',
                    lng: '',
                    radius:' ',
                    seqNumber: ''
                }
            },
            infoOptions: {
                pixelOffset: {
                    width: 0,
                    height: -35
                }
            },
            infoPosition: {lat: 23.5948976, lng: 121.0056306},
            infoOpened: false
        }),
        methods: {
            toggleInfoWindow(marker){
                this.center=marker.position;
                this.infoPosition = marker.position;
                this.infoContent = marker;
                this.infoOpened = true;
            }
        },
        created () {
            Bus.$on('messageClicked', (marker) => {
                this.infoOpened = false;
                this.toggleInfoWindow(marker);
                console.log('msg clicked! m');
                console.log(marker);
            });
        }
    }
</script>

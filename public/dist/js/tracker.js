/**
* ShineOS+ Form Validation
*
* ShineOS+ V3.0
**/

"use strict";

$(function () {
    $('input').on('click', function(e) {
       var myName = this.name;
       var myLabel = $(this).prop('placeholder');
       $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "input",
                type: $(this).prop('type'),
                ID: $(this).prop('id'),
                name: myName,
                curvalue: this.value,
                label: myLabel,
                action: "focus"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('input').on('blur', function(e) {
       var myName = this.name;
       var myLabel = $(this).prop('placeholder');
       $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "input",
                type: $(this).prop('type'),
                ID: $(this).prop('id'),
                name: myName,
                curvalue: this.value,
                label: myLabel,
                action: "blur"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('select').on('click', function(e) {
       var myName = this.name;
       $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "select",
                type: $(this).prop('type'),
                ID: $(this).prop('id'),
                name: myName,
                curvalue: this.options[this.selectedIndex].text,
                label: "",
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('select').on('change', function(e) {
       var myName = this.name;
       $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "select",
                type: $(this).prop('type'),
                ID: $(this).prop('id'),
                name: myName,
                curvalue: this.options[this.selectedIndex].text,
                label: "",
                action: "change"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('textarea').on('click', function(e) {
       var myName = this.name;
       $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "textarea",
                type: $(this).prop('type'),
                ID: $(this).prop('id'),
                name: myName,
                curvalue: this.value,
                label: "",
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('textarea').on('blur', function(e) {
       var myName = this.name;
       $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "textarea",
                type: $(this).prop('type'),
                ID: $(this).prop('id'),
                name: myName,
                curvalue: this.value,
                label: "",
                action: "blur"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('label.btn').on('click', function(){
        var myName = $(this).find("input").attr('name');
        var myValue = $(this).find("input").attr('value');
        var myLabel = $(this).text().trim();
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "radio",
                type: "",
                ID: $(this).find("input").prop('id'),
                name: myName,
                curvalue: myValue,
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('ins').on('click', function(){
        var myName = $(this).siblings('input').attr('name');
        var myValue = $(this).siblings('input').prop('checked');
        var myLabel = $(this).parents('label').text().trim();
        var myID = $(this).siblings('input').prop('id');
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "checkbox",
                type: "",
                ID: myID,
                name: myName,
                curvalue: myValue,
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('a.btn').on('click', function(){
        var myLabel = $(this).text().trim();
        var myID = $(this).prop('id');
        var myName = $(this).prop('name');
        var myHref = $(this).prop('href');
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "link",
                type: "button",
                ID: myID,
                name: myName,
                curvalue: myHref,
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('.sidebar-menu a').on('click', function(){
        var myLabel = $(this).text().trim();
        var myID = $(this).prop('id');
        var myName = $(this).prop('name');
        var myHref = $(this).prop('href');
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "link",
                type: "navigation",
                ID: myID,
                name: myName,
                curvalue: myHref,
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('.nav-tabs a').on('click', function(){
        var myLabel = $(this).text().trim();
        var myID = $(this).prop('id');
        var myName = $(this).prop('name');
        var myHref = $(this).prop('href');
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "link",
                type: "page-tab",
                ID: myID,
                name: myName,
                curvalue: myHref,
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('.breadcrumb a').on('click', function(){
        var myLabel = $(this).text().trim();
        var myID = $(this).prop('id');
        var myName = $(this).prop('name');
        var myHref = $(this).prop('href');
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "link",
                type: "breadcrumb",
                ID: myID,
                name: myName,
                curvalue: myHref,
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
    $('button').on('click', function(){
        var myLabel = $(this).text().trim();
        var myType = $(this).prop('type');
        var myHref = $(this).prop('onclick');
        var myID = $(this).prop('id');
        $.ajax({
            url : "/shineosv30-devpack/default/track",
            async : false,
            dataType : "json",
            data : {
                url: window.location.href,
                element: "button",
                type: myType,
                ID: myID,
                name: "",
                curvalue: "",
                label: myLabel,
                action: "click"
            },
            headers: {
              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            method: 'post',
            success : function( jsn ) {

            }
        });
    });
});

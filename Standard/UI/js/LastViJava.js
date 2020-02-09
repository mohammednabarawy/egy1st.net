$(function(){
  $('.spider').click(function(){
    var color = $(this).attr('data-color');
    $('#currentColor').val(color);
    $('#getColor').click();
  });
  $('a[href*="http://"]:not([href*="'+homeurl+'"])').attr('rel', 'nofollow');
  $('a[href*="https://"]:not([href*="'+homeurl+'"])').attr('rel', 'nofollow');
  $('a[href*="http://"]:not([href*="'+homeurl+'"])').attr("target", "_blank");
  $('.customSearch > div').click(function(){
    $(this).addClass('active').siblings().removeClass('active');
    $(this).find('ul').toggleClass('active').parent().siblings().find('ul').removeClass('active');
  });       
  var allData = {};
  $('.customSearch >div  li').on('click',function(e){
    e.stopPropagation();
    $(this).closest('.customSearch >div').addClass('active');
    if( $(this).hasClass('no') ){
      $(this).parent().parent().find('span').removeClass('active');
      $(this).parent().parent().find('em').removeClass('active').html($(this).text());
    }else {
      $(this).parent().parent().find('span').addClass('active');
      $(this).parent().parent().find('em').removeClass('active').html($(this).text());
    }
    $(this).addClass('active').siblings().removeClass('active');
    $('.customSearch ul').removeClass('active');
    $('.customSearch  div').removeClass('active');
    $('.releas-year ul li').each(function(){
      if($(this).hasClass('active')){
        $('#release').val($(this).data('value'));
      }
    });
    $('.headbtn').click(function(){
      $('.overlay , .search-trandy').toggleClass('active');
    });
    $('.genre ul li').each(function(){
      if($(this).hasClass('active')){
        $('#genre').val($(this).data('value'));
      }
    });
    $('.quality ul li').each(function(){
      if($(this).hasClass('active')){
        $('#quality').val($(this).data('value'));
      }
    });
    $('.category ul li').each(function(){
      if($(this).hasClass('active')){
        $('#cat').val($(this).data('value'));
      }
    });
    $('.language ul li').each(function(){
      if($(this).hasClass('active')){
        $('#lang').val($(this).data('value'));
      }
    }); 
    $('.nation ul li').each(function(){
      if($(this).hasClass('active')){
        $('#nation').val($(this).data('value'));
      }
    });
    $('.resolution ul li').each(function(){
      if($(this).hasClass('active')){
        $('#resolution').val($(this).data('value'));
      }
    });
    $('.age ul li').each(function(){
      if($(this).hasClass('active')){
        $('#age').val($(this).data('value'));
      }
    });  
  });
  $('#searchAuto').keyup(function(e){
    if($(this).val() != '' ){
      var search = $(this).val();
      $.ajax({
        url:ajaxurl,
        type: 'POST',
        data: {  search:search,action:'SearchComplete'},
        success: function(msg) {
          $('#SearchInnerList').html(msg);
          $('#SearchListResult').show();
          $('.BTMoreAuto').show();
          $('[data-src]').each(function(els, el){
            $(el).attr('src', $(el).data('src'));
            $(el).removeAttr('data-src');
          });
          $('[data-style]').each(function(els, el){
            $(el).attr('style', $(el).data('style'));
            $(el).removeAttr('data-style');
          });
        }
      });
    }else{
      $('#SearchListResult').hide();
    }
  });
  $('.OpenMenu').click(function(){
    $('.BadMenu,.OpenMenu').toggleClass('is-active');
  });
  $('.OpenSearching,.SearchingAuto>.clossat,.OverlaySearhing').click(function(){
    $('.SearchingAuto,.OverlaySearhing').toggleClass('active');
  });
  $('.OpenFilterSnagl').click(function(){
    if($(".SearchingArea.absolute").hasClass("Hauto")) {
      $(this).html('<span>البحث المتخصص </span><i class="fal fa-chevron-double-down"></i>');
      $(".SearchingArea.absolute").toggleClass("Hauto");
    }else {
      $(this).html('<span>اغلاق البحث المخصص </span><i class="fal fa-chevron-double-up"></i>');
      $(".SearchingArea.absolute").toggleClass("Hauto");
    }
  });
  $('.OpenInfo').click(function(){
    if($(this).parent().hasClass('active')){
      $(this).parent().toggleClass('active');
      $(this).toggleClass('active');
      $(this).html('<i class="fas fa-info"></i><span>تفاصيل</span>');
    }else{
      $(this).parent().toggleClass('active');
      $(this).toggleClass('active');
      $(this).html('<i class="fal fa-times"></i>');
    }
  });
  $('.MenuHeader ul > li ul.sub-menu').parent().append('<i class="fa fa-chevron-left showSub"></i>');
  $('.BadMenu ul > li ul.sub-menu').parent().append('<i class="fa fa-chevron-left showSub"></i>');
  $('.BadMenu ul > li ul.sub-menu').parent().click(function(){
    $(this).find('ul').slideToggle(300);
    if( $(this).find('i').hasClass('fa-chevron-left') ){
      $(this).find('i').attr('class','fa fa-chevron-down showSub');
    }else {
      $(this).find('i').attr('class','fa fa-chevron-left showSub');
    }
  });
  var lazyUpdate = function() {
    setTimeout(function(){
      $('body *').removeClass('LazyLoads');
      $('body *').removeClass('LazyMod');
      $('[data-src]').each(function(els, el){
        $(el).attr('src', $(el).data('src'));
        $(el).removeAttr('data-src');
      });
      $('[data-style]').each(function(els, el){
        $(el).attr('style', $(el).data('style'));
        $(el).removeAttr('data-style');
      });
    },3000);
  }
  $(document).ajaxComplete(lazyUpdate);
  setTimeout(function(){
    $('body *').removeClass('LazyLoads');
    $('body *').removeClass('LazyMod');
    $('[data-src]').each(function(els, el){
      $(el).attr('src', $(el).data('src'));
      $(el).removeAttr('data-src');
    });
    $('[data-style]').each(function(els, el){
      $(el).attr('style', $(el).data('style'));
      $(el).removeAttr('data-style');
    });
  },1500);
  $(window).on('scroll',function(){
    if ($(this).scrollTop() > 50) {
      $('#head').addClass("Fixed");
      $('div#wpadminbar').hide();
    } else {
      $('#head').removeClass("Fixed");
      $('div#wpadminbar').show();
    }
    if ($(this).scrollTop() > 500) {
      $('.SearchingArea').addClass("absolute");
    } else {
      $('.SearchingArea').removeClass("absolute");
    }
  });
  $('.scrollTop').click(function(){
    $('body,html').animate({
      scrollTop:0
    },1000);
  }); 
  setTimeout(function(){
    $('body').addClass('loaded');
    $('.MainActorsSlides:not(.Siblarrr)').show();
  },300);
  var Mcounet = 8,
  counter_tag = document.getElementById('LogoCount');
  var counter_up = setInterval(function(){
    if(Mcounet < 0) {
      $('.logo,.ddss,.spider').addClass('show');
      $('#LogoCount').remove();
    }else {
      counter_tag.innerHTML = Mcounet;
    }
    Mcounet--;
  },1000);
  if(ishome == true){
    $('.NewsGrid .slides').owlCarousel({
      margin:20,
      rtl: true,
      loop:true,
      autoWidth:true,
    });
    $('.NewsGrid .next').click(function(){
      $(this).parent().find('.owl-next').click();
    });
    $('.NewsGrid .prev').click(function(){
      $(this).parent().find('.owl-prev').click();
    });
    $('.OneSection').owlCarousel({
        loop:true,
        margin:15,
        nav:true,
        items:1,
        rtl:true,
    });
    $('.SectionContent .container .left').on('click',function(){
      $(this).parent().find('.OneSection .owl-prev').click();
    });
    $('.SectionContent .container .right').on('click',function(){
      $(this).parent().find('.OneSection .owl-next').click();
    }); 
    $('.MaiButtom>ul>li').click(function(){
      var filter = $(this).data('filter');
      var title = $(this).data('title');
      $('.BTNMores').html('المزيد من '+$(this).data('title')+'');
      $('.TopVBar>span>i').attr('class',$(this).data('icon'));
      $('.TopVBar>span>em').html($(this).data('title'));
      $(this).addClass('active').siblings().removeClass('active');
      $('.MainRelated').html('<div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            filter:filter,
            title:title,
            action:'filterTab'
          },
          success:function(data){
            $('.MainRelated').html(data);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            tfter  = $(this).data('filter');
          }
      })
    })
    var taboffset = postNumber;
    $('.BTNMores').click(function(){
      var tfter = $('.MaiButtom>ul>li.active').data('filter');
      $('.MainRelated').append('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            filter:tfter,
            offset:taboffset,
            action:'MoreTab'
          },
          success:function(data){
            $('.MainRelated .CLoad').remove();
            $('.MainRelated').append(data);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            taboffset = taboffset + postNumber;
          }
      })
    })
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
    var loadsonglast = false;
    var offset = 0;
    var ajaxPostloaded = $('#Sections');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1200  ){
        if( loadsonglast == false ) {
          if( $('#Sections').attr('data-loading') == 'false' ) {
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                  'offset':offset,
                  'action':'sectionLoadMore'
              },
              success: function(msg){
                $('#Sections .MSloader').remove();
                ajaxPostloaded.append(msg);
                loadsonglast = false;
                  $('img[data-src]').each(function(){
                    $(this).attr('src',$(this).data('src'));
                    $(this).removeAttr('data-src');
                  });
                  $('.OneSection').owlCarousel({
                      loop:true,
                      margin:15,
                      nav:true,
                      items:1,
                      rtl:true,
                  });
                  $('.SectionContent .container .left').on('click',function(){
                    $(this).parent().find('.OneSection .owl-prev').click();
                  });
                  $('.SectionContent .container .right').on('click',function(){
                    $(this).parent().find('.OneSection .owl-next').click();
                  }); 
              }
            });
            offset++;
          }
        }
      }
    });
    setTimeout(function(){
      $('.SlidesInner').addClass('show');
    },100);
    $('.SlidesInner .slides').owlCarousel({
      margin:10,
      rtl: true,
      loop:true,
      autoWidth:false,
      singleItem: true,
      items: 1
    });
    $('.SlidesInner .next').click(function(){
      $(this).parent().find('.slides .owl-next').click();
    });
    $('.SlidesInner .prev').click(function(){
      $(this).parent().find('.slides .owl-prev').click();
    });
  }
  if( thesingle == true ){
    $('.TrilerOverlay > .overlayClosse , .TrilerOverlay > span.closseTriller').click(function(){
      $('.TrilerOverlay').removeClass('active');
      $('.MasterTriller > *').remove();
    });  
    $('.TrilerOverlay > .overlayClosse , .TrilerOverlay > span.closseTriller').click(function(){
      $('.TrilerOverlay').removeClass('active');
      $('.MasterTriller > *').remove();
    });        
    $('ul.likes li.likes').click(function(){
      var like = $(this).data('like');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{ 
          like:like,
          id:postID,
          action:'likeAjax'
         },
        success:function(data){
          $('ul.likes li.likes span').html(data);              
        }
      });
    });
    $('ul.likes li.dislikes').click(function(){
      var like = $(this).data('like');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{ 
          like:like,
          id:postID,
          action:'dislikeAjax'
         },
        success:function(data){
          $('ul.likes li.dislikes span').html(data);
        }
      });
    });
    $('.MasterTabRelated>.ItemTabs').click(function(){
      var filter = $(this).data('taxonomy');
      var taxid = $(this).data('id');
      var dtype = $(this).data('type');
      var offset = 0;
      $('.MoreLoaded').show();
      $('.MoreLoaded').attr('data-id',$(this).data('id'));
      $('.MoreLoaded').attr('data-taxonomy',$(this).data('taxonomy'));
      $('.MoreLoaded').attr('data-action',$(this).data('action'));
      $('.MoreLoaded').attr('data-type',$(this).data('type'));
      $('.TitleSection').html($(this).data('title'));
      $('.TitleMasterImg > i').attr('class',$(this).data('icon'));
      $(this).addClass('active').siblings().removeClass('active');
      $('.MainRelated').html('<div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            action:''+$(this).data('action')+'',
            "offset":offset,
            "filter":filter,
            "taxid":taxid,
            "dtype":dtype,
          },
          success:function(data){
            $('.MainRelated').html(data);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            offset = postNumber;
          }
      })
    });
    var loadedmore = $('.MainRelated');
    var offset = postNumber;
    $('.MoreLoaded').on('click',function(){
      var mfilter = $(this).data('taxonomy');
      var taxid = $(this).data('id');
      var mdtype = $(this).data('type');
      loadedmore.append('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{
          "action":''+$(this).data('action')+'',
          "offset":offset,
          "taxid":taxid,
          "filter":mfilter,
          "dtype":mdtype,
        },
        success:function(data){
          $('.MainRelated .CLoad').remove();
          loadedmore.append(data);
          $('[data-src]').each(function(els, el){
            $(el).attr('src', $(el).data('src'));
            $(el).removeAttr('data-src');
          });
          $('[data-style]').each(function(els, el){
            $(el).attr('style', $(el).data('style'));
            $(el).removeAttr('data-style');
          });
          loadsonglast = false;
          offset = offset + postNumber;
        }
      });
    });
    $('.WatchServers > li').click(function(){
      $('.WatchServers > li').removeClass('active');
      $(this).addClass('active');
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: 'action=GetServer&post='+postID+'&id='+$(this).data('server')+'&type='+$(this).data('type'),
        success: function(msg) {
          $('#EmbedCode').html(msg);
        }
      });
    });
    $('.OneSection').owlCarousel({
        loop:true,
        margin:15,
        nav:true,
        items:1,
        rtl:true,
    });
    $('.SectionContent .container .left').on('click',function(){
      $(this).parent().find('.OneSection .owl-prev').click();
    });
    $('.SectionContent .container .right').on('click',function(){
      $(this).parent().find('.OneSection .owl-next').click();
    }); 
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
    $('.OpenServers').on('click',function(){
        $('.OpenViewer').click();
    });
    $(".MasterToggleItem > li").on('click',function(){
      var songsLoaded = $('.MasterToggleOpen > .InnerESP');
      var slug = $(this).data('slug');
      var posid = $(this).data('posid');
      $('.MoreEpesode > a').attr('href',$(this).data('href'));
      $('.MoreEpesode > a').html('<i class="fab fa-pushed"></i><span>باقي حلقات  '+$(this).data('title')+'</span>');
      $(this).addClass('active').siblings().removeClass('active');
      songsLoaded.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{
          "slug":slug,
          "posid":posid,
          "action":''+$(this).data('type')+'',
        },
        success:function(data){
          $('.MasterToggleOpen > .InnerESP .CLoad').remove();
          if(data == '' ){
            songsLoaded.html('<h2 class="noMorePosts">عفوا لم يتم اضافة حلقات لهذا الموسم </h2>'); 
          }else {
            songsLoaded.html(data);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
          }
        }
      });
    });
    if(assemblies == true) {
      $('.owlassemblies').owlCarousel({
          loop:true,
          margin:10,
          nav:true,
          items:1,
          rtl:true,
      });
      $('.assemblies .left').on('click',function(){
        $(this).parent().find('.owlassemblies .owl-prev').click();
      });
      $('.assemblies .right').on('click',function(){
        $(this).parent().find('.owlassemblies .owl-next').click();
      });
    }
    if(trailer == true){ 
      $('.OpenTriller').click(function(){
        $('.TrilerOverlay').addClass('active');
        $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{ 
            id:postID,
            action:'Triller'
           },
          success:function(data){
            $('.MasterTriller').html(data);              
          }
        });
      });
    }
    if(CounterOpt == true){
      var c = ADCounter;
        var counter = setInterval(function(){
        if(c == 0) {
          clearInterval(counter);
          $('.download.text-center').remove();
          $('.DownloadSection').addClass('show');
          var videoLoaded = $('.DownloadSection');
          var id = postID;
          $.ajax({
            type:'POST',
            url:ajaxurl,
            data:{ "id":id,action:'firstServer',dtype:downloadType},
            success:function(data){
              videoLoaded.html(data);
              $('.WatchServers > li').click(function(){
                  $('.WatchServers > li').removeClass('active');
                  $(this).addClass('active');
                $('#EmbedCode').html($(this).find('noscript').html());
              }); 

            }
          });
        }
        $('.MskaDiv .MultyCounter').html(c);
        c--;
      },1000);
    }else{
      setTimeout(function(){
        $('.download.text-center').remove();
        $('.DownloadSection').addClass('show');
        var videoLoaded = $('.DownloadSection');
        var id = postID;
        $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{ "id":id,action:'firstServer'},
          success:function(data){
            videoLoaded.html(data);
            $('.WatchServers > li').click(function(){
                $('.WatchServers > li').removeClass('active');
                $(this).addClass('active');
              $('#EmbedCode').html($(this).find('noscript').html());
            });                   
          }
        });
      },300);
    }
  }
  if(isArchive == true){ 
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
    $('.sliderpin-next').click(function(){
       $(".SliderMaster > ul.owl-carousel .owl-prev").click();
    });
    $('.sliderpin-prev').click(function(){
        $(".SliderMaster > ul.owl-carousel .owl-next").click();
    });
    if(catnews == true){ 
        $('.OwlNews.owl-carousel').owlCarousel({
            loop:true,
            margin:15,
            nav:true,
            items:1,
            rtl:true,
        });
        $('.NewsSection .container .left').on('click',function(){
          $(this).parent().find('.OwlNews.owl-carousel .owl-prev').click();
        });
        $('.NewsSection .container .right').on('click',function(){
          $(this).parent().find('.OwlNews.owl-carousel .owl-next').click();
        });
        // LOADMORE SONGS ARCHIVE SONGSTabs
        var loadsonglast = false;
        var offset = postNumber;
        var ajaxPostloaded = $('.MainRelated');
        var bottomlastsong = $('.FooterLoadedOne');
        $(window).scroll(function() {
          if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
            if( loadsonglast == false ) {
              if( $('.MainRelated').attr('data-loading') == 'false' ) {
                ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
                loadsonglast = true;
                $.ajax({
                  url: ajaxurl,
                  type: 'POST',
                  data: {
                    "offset":offset,
                    "taxonomy":arcTaxonomy, 
                    "termid":arcid,
                    "action":'NewsMore'
                  },
                  success: function(msg){
                    $('.MainRelated .FucL').remove();
                    $('.MainRelated').append(msg);
                    $('[data-style]').each(function(els, el){
                      $(el).attr('style', $(el).data('style'));
                      $(el).removeAttr('data-style');
                    });
                    loadsonglast = false;
                    offset = offset + postNumber;
                  }
                });
              }
            }
          }
        });
    }else{
      setTimeout(function(){
        $('.SlidesInner').addClass('show');
      },300);
      $('.SlidesInner .slides').owlCarousel({
        margin:10,
        rtl: true,
        loop:true,
        autoWidth:false,
        singleItem: true,
        items: 1
      });
      $('.SlidesInner .next').click(function(){
        $(this).parent().find('.slides .owl-next').click();
      });
      $('.SlidesInner .prev').click(function(){
        $(this).parent().find('.slides .owl-prev').click();
      });
      // LOADMORE SONGS ARCHIVE SONGSTabs
      var loadsonglast = false;
      var offset = postNumber;
      var ajaxPostloaded = $('.MainRelated');
      var bottomlastsong = $('.FooterLoadedOne');
      $(window).scroll(function() {
        if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
          if( loadsonglast == false ) {
            if( $('.MainRelated').attr('data-loading') == 'false' ) {
              ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
              loadsonglast = true;
              $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                  "offset":offset,
                  "slug":arcSlug,
                  "taxonomy":arcTaxonomy, 
                  "termid":arcid,
                  "action":'archiveMore'
                },
                success: function(msg){
                  $('.MainRelated .FucL').remove();
                  $('.MainRelated').append(msg);
                  $('[data-style]').each(function(els, el){
                    $(el).attr('style', $(el).data('style'));
                    $(el).removeAttr('data-style');
                  });
                  loadsonglast = false;
                  offset = offset + postNumber;
                }
              });
            }
          }
        }
      });
    } 
  }
  if(isPage == true){
    setTimeout(function(){
      $('.SlidesInner').addClass('show');
    },100);
    $('.SlidesInner .slides').owlCarousel({
      margin:10,
      rtl: true,
      loop:true,
      autoWidth:false,
      singleItem: true,
      items: 1
    });
    $('.SlidesInner .next').click(function(){
      $(this).parent().find('.slides .owl-next').click();
    });
    $('.SlidesInner .prev').click(function(){
      $(this).parent().find('.slides .owl-prev').click();
    });
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
  }
  if(tvshow == true){
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,filter:pageType,
                "action":'TvPro'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  }
  if(trending == true){ 
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,filter:trendType,
                action:'TreangingMore'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  } 
  if(movies == true){
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,filter:moviType,
                action:'moviesMore'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  } 
  if(series == true){
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,filter:serType,
                "action":'tvMore'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  }
  if(advsearch == true){
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,
                "filter":'',
                "cat":catData,
                "release": releaseData,
                "quality": qualityData,
                "quality": langData,
                "nation": nationData,
                "resolution": resolutionData,
                "genre": genreData,
                "action":'AdvSearch'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  }
  if(sections == true){
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,id:postID,
                "action":'MoreSections'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  }
  if(customlink == true){
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,id:postID,
                "action":'customlink'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  } 
  if(latestnew == true){
    $('.NewsGrid .slides').owlCarousel({
      margin:20,
      rtl: true,
      loop:true,
      autoWidth:true,
    });
    $('.NewsGrid .next').click(function(){
      $(this).parent().find('.owl-next').click();
    });
    $('.NewsGrid .prev').click(function(){
      $(this).parent().find('.owl-prev').click();
    });
    // LOADMORE SONGS ARCHIVE SONGSTabs
    var loadsonglast = false;
    var offset = postNumber;
    var ajaxPostloaded = $('.MainRelated');
    var bottomlastsong = $('.FooterLoadedOne');
    $(window).scroll(function() {
      if($(this).scrollTop() > bottomlastsong.offset().top - 1000  ){
        if( loadsonglast == false ) {
          if( $('.MainRelated').attr('data-loading') == 'false' ) {
            ajaxPostloaded.append('<div class="FucL"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
            loadsonglast = true;
            $.ajax({
              url: ajaxurl,
              type: 'POST',
              data: {
                "offset":offset,
                "action":'NewsMore'
              },
              success: function(msg){
                $('.MainRelated .FucL').remove();
                $('.MainRelated').append(msg);
                $('[data-style]').each(function(els, el){
                  $(el).attr('style', $(el).data('style'));
                  $(el).removeAttr('data-style');
                });
                loadsonglast = false;
                offset = offset + postNumber;
              }
            });
          }
        }
      }
    });
  }
  if(issearch == true){
    $(".MainActorsSlidesInner").owlCarousel({
      autoWidth: true,
      stopOnHover: true,
      autoPlay: true,
      singleItem: true,
      loop: true,
      rtl: true,
      addClassActive: true,
      navText : ['<a href="javascript:void(0);" class="SliderOwl-next"><i class="fa fa-angle-left"></i></a>','<a href="javascript:void(0);" class="SliderOwl-prev"><i class="fa fa-angle-right"></i></a>'],
    });
  }
});
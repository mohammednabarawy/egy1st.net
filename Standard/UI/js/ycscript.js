$(function(){
    	var reports = $('.reportpopup');
			$('.report').click(function(){
				reports.addClass('active');
				$('.reportpopup input[name="your-subject"]').val($(this).data('title'));
			});
			$('.reportpopup').click(function(){
				reports.removeClass('active');
			});
			$('.reportbox').click(function(w){
				w.stopPropagation() 
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
     $('.MediaQueryLeft').addClass("ThTop");
     $('.RightPoster').addClass("ThTop");
    } else {
      $('.RightPoster').removeClass("ThTop");
    }
    if ($(this).scrollTop() > 500) {
      $('.SearchingArea').addClass("absolute");
    }else{
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
  if(ishome == true){
    setTimeout(function(){
      $('.SliderTopAjax').addClass('show');
    },100);
    $('.SliderTopAjax').owlCarousel({
        loop:true,
        nav:true,
        items:1,
        rtl:true,
        singleItem: true,
        slideBy: 1,
        navText : ['<a href="javascript:void(0);" class="FunClick SliderOwl-next"><i class="far fa-chevron-left"></i>','<a href="javascript:void(0);" class="FunClick SliderOwl-prev"><i class="far fa-chevron-right"></i></a>'],
    })
    $('body').on('click','.TopAjaxB', function(){
      var topID = $(this).data('id');
      var topContent = $('.InnerGets');
      $('.DoneClick').css({"pointer-events":'none', 'opacity':'.5'});
      topContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            id:topID,
            action:'SlidAjax'
          },
          success:function(data){
            topContent.html(data);
            setTimeout(function(){
              topContent.addClass('active');
            },100);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            $('.DoneClick').css({"pointer-events":'inherit', 'opacity':'1'});
          }
      })
    });
    $('body').on('click', '.FunClick', function(){
      var topNerid = $('.SliderTopAjax .owl-item.active .TopAjaxB').data('id');
      var newTopContent = $('.InnerGets');
      $('.FunClick').css({"pointer-events":'none', 'opacity':'.5'});
      $('.TopAjaxB').css({"pointer-events":'none'});
      newTopContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            id:topNerid,
            action:'SlidAjax'
          },
          success:function(data){
            newTopContent.html(data);
            setTimeout(function(){
              newTopContent.addClass('active');
            },100);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            $('.FunClick').css({"pointer-events":'inherit', 'opacity':'1'});
            $('.TopAjaxB').css({"pointer-events":'inherit'});
          }
      });
    });
    $('body').on('click','.TrailerOpenPost',function(){
      var idtrailer = $(this).data('trailer');
      var trailerIn = $('.TopsTrilHere[data-open="'+idtrailer+'"]');
      var link = $(this).data('link');
      $(this).addClass('show');
      setTimeout(function(){
        $('.PlayNow').html('<a href="'+link+'"><i class="fas fa-play"></i><span>المشاهدة</span></a>');
      },100);
      $('.TillerTop').addClass('show');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{ 
          id:idtrailer,
          action:'Triller'
         },
        success:function(data){
          trailerIn.html(data);
        }
      });
    });
    $('body').on('click','.ClossTF',function(){
      $(this).parent().removeClass('show');
      $(this).parent().find('.TopsTrilHere > *').remove();
      $('.PlayNow').html('<i class="fal fa-play"></i><span>الأعلان</span>');
      $('.TrailerOpenPost').removeClass('show');
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
              }
            });
            offset = offset + 3;
          }
        }
      }
    });
    $('body').on('click','.InAjaxBlock', function(){
      var theID = $(this).data('id');
      var sectionID = $(this).data('secid');
      var sectionContent = $('.datasection[data-section="'+sectionID+'"] .OneSection');
      $('.DoneClick').css({"pointer-events":'none', 'opacity':'.5'});
      sectionContent.removeClass('active');
      $('.TopAjaxB').css({"pointer-events":'none'});
      sectionContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            id:theID,
            action:'SetionOpen'
          },
          success:function(data){
            sectionContent.html(data);
            setTimeout(function(){
              sectionContent.addClass('active');
            },100);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            $('.DoneClick').css({"pointer-events":'inherit', 'opacity':'1'});
            $('.TopAjaxB').css({"pointer-events":'inherit'});
          }
      })
    });
    $('body').on('click', '.DoneClick', function(){
      var secnewID = $(this).data('section');
      var nerID = $('.MultyBlocks[data-section="'+secnewID+'"] .owl-item.active .InAjaxBlock').data('id');
      var vhcontent = $('.datasection[data-section="'+secnewID+'"] .OneSection');
      $('.DoneClick').css({"pointer-events":'none', 'opacity':'.5'});
      $('.TopAjaxB').css({"pointer-events":'none'});
      vhcontent.removeClass('active');
      vhcontent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            id:nerID,
            action:'SetionOpen'
          },
          success:function(data){
            vhcontent.html(data);
            setTimeout(function(){
              vhcontent.addClass('active');
            },100);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            $('.DoneClick').css({"pointer-events":'inherit', 'opacity':'1'});
            $('.TopAjaxB').css({"pointer-events":'inherit'});
          }
      });
    });
    $('body').on('click','.DivTriller',function(){
      var TrillerID = $(this).data('id');
      var vhTriller = $('.TillerBlock[data-open="'+TrillerID+'"]');
      var innerTriller = $('.TrilHere[data-open="'+TrillerID+'"]');
      var overlayTriller = $('.TrOver[data-open="'+TrillerID+'"]');
      vhTriller.addClass('show');
      overlayTriller.addClass('show');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{ 
          id:TrillerID,
          action:'Triller'
         },
        success:function(data){
          innerTriller.html(data);
        }
      });
    });
    $('body').on('click','.ClossTr',function(){
      $(this).parent().removeClass('show');
      $(this).parent().find('.TrilHere > *').remove();
      $(this).parent().parent().find('.TrOver').removeClass('show');
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
    $(".MasterToggleItem > li").on('click',function(){
      var songsLoaded = $('.MasterToggleOpen > .InnerESP');
      var slug = $(this).data('slug');
      var posid = $(this).data('posid');
      $('.MoreEpesode > a').attr('href',$(this).data('href'));
      $('.content.ISInSingle .TitleBarD > a').attr('href',$(this).data('href'));
      $('.content.ISInSingle .TitleBarD > a').html(''+$(this).data('title')+'');
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
      $('.OpenTNoew').click(function(){
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
    $('.DownloadServers').on('click',function(){
      $('html, body').animate({scrollTop: $('#DownloadTable').offset().top - 100 },500);
    });  
    $('.OpenSeasons').on('click',function(){
      $('html, body').animate({scrollTop: $('.ToggleMange').offset().top - 180 },500);
    });  
    $('.OpenServers').on('click',function(){
      if($('.OpenServers').attr('data-loaded') == 'false'){
        $('html, body').animate({scrollTop: $('.containers').offset().top - 130 },500);
        setTimeout(function(){
          var videoLoaded = $('#EmbedCode');
          var id = postID;
          $.ajax({
            type:'POST',
            url:ajaxurl,
            data:{ "id":id,action:'firstServer'},
            success:function(data){
              videoLoaded.css({"background":'none'});
              videoLoaded.html(data);
            }
          });
        },50);
      }else{
        $('html, body').animate({scrollTop: $('.containers').offset().top - 130 },500);
      }
    });
    $('.WhatchOpenServ').on('click',function(){
      setTimeout(function(){
        var videoLoaded = $('#EmbedCode');
        var id = postID;
        $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{ "id":id,action:'firstServer'},
          success:function(data){
            videoLoaded.css({"background":'none'});
            videoLoaded.html(data);
          }
        });
      },50);
    });
    $('body').on('click','.WatchServers > li',function(){
      $('.WatchServers > li').removeClass('active');
      $(this).addClass('active');
      $('#EmbedCode').html($(this).find('noscript').html());
    });
  }
  if(isArchive == true){ 
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
        $('.SliderTopAjax').addClass('show');
      },100);
      $('.SliderTopAjax').owlCarousel({
          loop:true,
          nav:true,
          items:1,
          rtl:true,
          singleItem: true,
          slideBy: 1,
          navText : ['<a href="javascript:void(0);" class="FunClick SliderOwl-next"><i class="far fa-chevron-left"></i>','<a href="javascript:void(0);" class="FunClick SliderOwl-prev"><i class="far fa-chevron-right"></i></a>'],
      });
      $('body').on('click','.TopAjaxB', function(){
        var topID = $(this).data('id');
        var topContent = $('.InnerGets');
        $('.DoneClick').css({"pointer-events":'none', 'opacity':'.5'});
        topContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
        $.ajax({
            type:'POST',
            url:ajaxurl,
            data:{
              id:topID,
              action:'SlidAjax'
            },
            success:function(data){
              topContent.html(data);
              setTimeout(function(){
                topContent.addClass('active');
              },100);
              $('[data-src]').each(function(els, el){
                $(el).attr('src', $(el).data('src'));
                $(el).removeAttr('data-src');
              });
              $('[data-style]').each(function(els, el){
                $(el).attr('style', $(el).data('style'));
                $(el).removeAttr('data-style');
              });
              $('.DoneClick').css({"pointer-events":'inherit', 'opacity':'1'});
            }
        })
      });
      $('body').on('click', '.FunClick', function(){
        var topNerid = $('.SliderTopAjax .owl-item.active .TopAjaxB').data('id');
        var newTopContent = $('.InnerGets');
        $('.FunClick').css({"pointer-events":'none', 'opacity':'.5'});
        $('.TopAjaxB').css({"pointer-events":'none'});
        newTopContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
        $.ajax({
            type:'POST',
            url:ajaxurl,
            data:{
              id:topNerid,
              action:'SlidAjax'
            },
            success:function(data){
              newTopContent.html(data);
              setTimeout(function(){
                newTopContent.addClass('active');
              },100);
              $('[data-src]').each(function(els, el){
                $(el).attr('src', $(el).data('src'));
                $(el).removeAttr('data-src');
              });
              $('[data-style]').each(function(els, el){
                $(el).attr('style', $(el).data('style'));
                $(el).removeAttr('data-style');
              });
              $('.FunClick').css({"pointer-events":'inherit', 'opacity':'1'});
              $('.TopAjaxB').css({"pointer-events":'inherit'});
            }
        });
      });
      $('body').on('click','.TrailerOpenPost',function(){
        var idtrailer = $(this).data('trailer');
        var trailerIn = $('.TopsTrilHere[data-open="'+idtrailer+'"]');
        var link = $(this).data('link');
        $(this).addClass('show');
        setTimeout(function(){
          $('.PlayNow').html('<a href="'+link+'"><i class="fas fa-play"></i><span>المشاهدة</span></a>');
        },100);
        $('.TillerTop').addClass('show');
        $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{ 
            id:idtrailer,
            action:'Triller'
           },
          success:function(data){
            trailerIn.html(data);
          }
        });
      });
      $('body').on('click','.ClossTF',function(){
        $(this).parent().removeClass('show');
        $(this).parent().find('.TopsTrilHere > *').remove();
        $('.PlayNow').html('<i class="fal fa-play"></i><span>الأعلان</span>');
        $('.TrailerOpenPost').removeClass('show');
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
      $('.SliderTopAjax').addClass('show');
    },100);
    $('.SliderTopAjax').owlCarousel({
        loop:true,
        nav:true,
        items:1,
        rtl:true,
        singleItem: true,
        slideBy: 1,
        navText : ['<a href="javascript:void(0);" class="FunClick SliderOwl-next"><i class="far fa-chevron-left"></i>','<a href="javascript:void(0);" class="FunClick SliderOwl-prev"><i class="far fa-chevron-right"></i></a>'],
    });
    $('body').on('click','.TopAjaxB', function(){
      var topID = $(this).data('id');
      var topContent = $('.InnerGets');
      $('.DoneClick').css({"pointer-events":'none', 'opacity':'.5'});
      topContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            id:topID,
            action:'SlidAjax'
          },
          success:function(data){
            topContent.html(data);
            setTimeout(function(){
              topContent.addClass('active');
            },100);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            $('.DoneClick').css({"pointer-events":'inherit', 'opacity':'1'});
          }
      })
    });
    $('body').on('click', '.FunClick', function(){
      var topNerid = $('.SliderTopAjax .owl-item.active .TopAjaxB').data('id');
      var newTopContent = $('.InnerGets');
      $('.FunClick').css({"pointer-events":'none', 'opacity':'.5'});
      $('.TopAjaxB').css({"pointer-events":'none'});
      newTopContent.html('<div class="CLoad"><div class="FucL loader-wrapper"><div class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader2" class="loader"><div class="roller"></div><div class="roller"></div></div><div id="loader3" class="loader"><div class="roller"></div><div class="roller"></div></div></div></div>');
      $.ajax({
          type:'POST',
          url:ajaxurl,
          data:{
            id:topNerid,
            action:'SlidAjax'
          },
          success:function(data){
            newTopContent.html(data);
            setTimeout(function(){
              newTopContent.addClass('active');
            },100);
            $('[data-src]').each(function(els, el){
              $(el).attr('src', $(el).data('src'));
              $(el).removeAttr('data-src');
            });
            $('[data-style]').each(function(els, el){
              $(el).attr('style', $(el).data('style'));
              $(el).removeAttr('data-style');
            });
            $('.FunClick').css({"pointer-events":'inherit', 'opacity':'1'});
            $('.TopAjaxB').css({"pointer-events":'inherit'});
          }
      });
    });
    $('body').on('click','.TrailerOpenPost',function(){
      var idtrailer = $(this).data('trailer');
      var trailerIn = $('.TopsTrilHere[data-open="'+idtrailer+'"]');
      var link = $(this).data('link');
      $(this).addClass('show');
      setTimeout(function(){
        $('.PlayNow').html('<a href="'+link+'"><i class="fas fa-play"></i><span>المشاهدة</span></a>');
      },100);
      $('.TillerTop').addClass('show');
      $.ajax({
        type:'POST',
        url:ajaxurl,
        data:{ 
          id:idtrailer,
          action:'Triller'
         },
        success:function(data){
          trailerIn.html(data);
        }
      });
    });
    $('body').on('click','.ClossTF',function(){
      $(this).parent().removeClass('show');
      $(this).parent().find('.TopsTrilHere > *').remove();
      $('.PlayNow').html('<i class="fal fa-play"></i><span>الأعلان</span>');
      $('.TrailerOpenPost').removeClass('show');
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
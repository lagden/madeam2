window.addEvent('domready',function() {

	jQuery('div.tweetsFront').tweet({
		join_text: "auto",
		username: "frontlinebrasil",
		avatar_size: null,
		count:2,
		auto_join_text_default: "", 
		auto_join_text_ed: "",
		auto_join_text_ing: "",
		auto_join_text_reply: "",
		auto_join_text_url: "",
		loading_text: "Carregando tweets...",
		linkFirst:true
	});

});
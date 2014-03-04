<?php

	class qa_html_theme extends qa_html_theme_base
	{	

		function head_custom() {
			//canonical tags for other pages like question Cat and Unanswered Cat
			qa_html_theme_base::head_custom();
			if ($this->template == "unanswered" || $this->template == "questions") {
				$this->output('<link rel="canonical" href="'.qa_opt('site_url').$this->template.'"/>');
			}
			//some custom styles for my account page
			if ($this->request == "account") {
				$this->output('<style>.qa-part-form-profile .qa-form-wide-table {background: #E7F5F2;width: 730px;padding-bottom: 5px;</style>');		
			}			
		}

		function body_prefix()
		{
			//top blue bar
			$this->output('<!-- Top Blue -->');
			$this->output('<div class="qa-top-blue">');
			$this->output('</div>');
			$this->output('<!-- Top Blue ENDS -->');

			qa_html_theme_base::body_prefix();
		}

		function body_suffix()
		{
			//bottom grey bar
			$this->output('<div class="qa-bottom-grey">');
			$this->nav('footer');
			$this->attribution();			
			$this->output('</div>');

			qa_html_theme_base::body_suffix();
		}	
		
		function footer()
		{
			$this->output('<div class="qa-footer">');
			$this->footer_clear();
			$this->output('</div> <!-- END qa-footer -->', '');
		}		

		function q_item_stats($q_item)
		{
			$this->output('<div class="qa-q-item-stats">');

			$this->voting($q_item);
			$this->a_count($q_item);
			qa_html_theme_base::view_count($q_item);			

			$this->output('</div>');
		}	

		function view_count($q_item) 
		{	
			// prevent display of view count in the usual place
			if ($this->template=='question')
				qa_html_theme_base::view_count($q_item);
		}						

		function q_item_title($q_item)
		{
			//Make Listing page titles output in an H2
			$this->output(
				'<div class="qa-q-item-title">',
				'<h2><a href="'.$q_item['url'].'">'.$q_item['title'].'</a></h2>',
				'</div>'
			);
		}

		function page_title_error()
		{
			//re-write the page title function to
			//make the page H1 tags Search Engine 
			//friendly

			$favorite=@$this->content['favorite'];
			if (isset($favorite)) {
				$this->output('<div class="qa-favoriting-contain">');
				$this->output('<form '.$favorite['form_tags'].'>');
				$this->favorite();
				$this->form_hidden_elements(@$favorite['form_hidden']);
				$this->output('</form>');
				$this->output('</div>');
			}				

			$this->output('<h1>');
			$this->title();
			$this->output('</h1>');

			if (isset($this->content['error']))
				$this->error(@$this->content['error']);
		}		

		function attribution()
		{
			$this->output(
				'<div class="qa-attribution">',
				'&nbsp;| Minimalist Answer Theme by <a href="http://www.digitizormedia.com/qa?ref='.qa_opt('site_url').'">Digitizor Media</a>',
				'</div>'
			);
			
			qa_html_theme_base::attribution();
			
		}

		function q_view_buttons($q_view)
		{
			//Social Media Buttons for question
			//$page_url = urlencode(str_replace("///","/",str_replace("..","",qa_opt('site_url').$q_view['url'])));
			$page_url = urlencode(qa_opt('site_url').$this->request);
			$page_title = urlencode($q_view['raw']['title']);
			$this->output(
				'<div class="qa-share-buttons">',
					'<div class="qa-share-text">Share on </div>',
					'<div class="qa-share-final">',
						'<a href="https://plus.google.com/share?url='.$page_url.'" target="_blank" class="qa-share-gp" title="share this question on Google+">share on gp</a>',
						'<a href="https://www.facebook.com/sharer/sharer.php?u='.$page_url.'&ref=fbshare&t='.$page_title.'" target="_blank" class="qa-share-fb" title="share this question on Facebook">share on fb</a>',
						'<a href="https://twitter.com/intent/tweet?original_referer='.$page_url.'&text='.$page_title.'&url='.$page_url.'" target="_blank" class="qa-share-tw" title="share this question on Twitter">share on tw</a>',
						'<a href="http://www.linkedin.com/shareArticle?mini=true&url='.$page_url.'&title='.$page_title.'&summary='.$page_title.'" target="_blank" class="qa-share-li" title="share this question on Linkedin">share on li</a>',
					'</div>',
					'<div class="qa-clear"></div>',
				'</div>'
			);			
			qa_html_theme_base::q_view_buttons($q_view);
		}	

	}

/*
	Omit PHP closing tag to help avoid accidental output
*/
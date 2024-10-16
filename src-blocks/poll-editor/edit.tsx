
import {useBlockProps} from '@wordpress/block-editor';
import './editor.scss';
import {type BlockEditProps} from '@wordpress/blocks';
import {Button, TextControl} from '@wordpress/components';
import {usePollButtonLabel, usePollOptions} from "../../src/hooks/usePolls";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 */
export type Attributes = {
	variant: string;
};
export default function Edit(props: BlockEditProps<Attributes>) {


	const [options, setOptions] = usePollOptions();
	const [text, setText] = usePollButtonLabel();

	const handleChangeText = (index: number) => (text: string) => {
		setOptions(
			options.map((o, i) => {
				return {
					...o,
					label: index == i ? text : o.label,
				};
			})
		);
	};

	function handleAddOption() {
		setOptions(
			[
				...options,
				{
					label: "",
					counter: 0,
				},
			]
		);
	}

	const handleRemoveOption =(index: number) => () => {
		if (options.length <= 2) return;
		setOptions(options.filter((o,i)=> i != index));
	}

	function handleButtonLabelChange(text: string){
		setText(text);
	}

	const overall = options.reduce((value, item)=>value + Number(item.counter), 0)

	return (
		<div {...useBlockProps({
			className: "start-poll__poll-editor"
		})}>
				<div data-options>
					{options.map((o, index) => {
						const percent = Math.round(((overall > 0) ? Number(o.counter) / overall : 0)*100);
						return (
							<div data-option>
								<TextControl
									label={`Antwort ${index + 1}`}
									value={o.label}
									onChange={handleChangeText(index)}
									className="start-poll__text-control"
								/>
								<div>{percent} % ( {o.counter} Stimmen )</div>
								<div data-chart>
									<div data-bar style={{width: percent+"%" }}></div>
								</div>
								<Button
									variant="secondary"
									isDestructive
									onClick={handleRemoveOption(index)}
								>
									Löschen
								</Button>
							</div>
						);
					})}
				</div>

			<div data-option-controls>
				<Button variant="secondary" onClick={handleAddOption}>
					Option hinzufügen
				</Button>
			</div>

			<hr />

			<TextControl
				label="Label des Submit Buttons"
				placeholder="Senden"
				value={text}
				onChange={handleButtonLabelChange}
				className="start-poll__text-control--button-label"
			/>
		</div>
	);
}

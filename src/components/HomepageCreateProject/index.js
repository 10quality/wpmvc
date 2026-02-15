import useBaseUrl from '@docusaurus/useBaseUrl';
import styles from './styles.module.css';

const Project = {
    heading: 'Development is fast and easy!',
    paragraph: (
        <>
        <strong>WordPress MVC (WPMVC)</strong> framework is <strong>FREE</strong>, is Open Source, and will help you develop and deploy awesome themes and plugins faster and easier.
        </>
    ),
    subParagraph: 'Via composer command:',
    command: 'composer create-project 10quality/wpmvc {your-app-name}',
};

export default function HomepageCreateProject(props) {
    const Style = {
        '--bg-img': `url(${props.bgUrl})`,
    };
    return (
        <section className={styles.createProject}>
            <div className={styles.underlay} style={Style}></div>
            <h2>{Project.heading}</h2>
            <p>{Project.paragraph}</p>
            <p className={styles.viaComposer}>{Project.subParagraph}</p>
            <code className={styles.command}>{Project.command}</code>
        </section>
    );
}